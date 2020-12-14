<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public $weeks = [
        'sun' => '日',
        'mon' => '月',
        'tue' => '火',
        'wed' => '水',
        'thu' => '木',
        'fri' => '金',
        'sat' => '土'
    ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account, Request $request)
    {
        $request->session()->put('receipt.service', 'delivery');

        $sub_domain = $account;
        $manages = DB::table('manages')->where('domain', $sub_domain)->first();
        $shops = DB::table('shops')->where('manages_id', $manages->id)->get();
        $slides = DB::table('slides')->where('manages_id', $manages->id)->first();
        $categories = DB::table('categories')->where('manages_id', $manages->id)->orderBy('sort_id', 'asc')->get();
        $posts = DB::table('posts')->where('manages_id', $manages->id)->limit(3)->get();

        // 念のため削除
        if (session('cart.products') == null || count(session('cart.products')) <= 0) {
            session()->forget('cart');
        }

        $options = [];
        $products = [];
        foreach ($categories as $key => $cat) {
            // オプション
            if (DB::table('options')->where('categories_id', $cat->id)->exists()) {
                $options[$cat->id] = DB::table('options')->where('categories_id', $cat->id)->get();
            }
            // 商品
            if (DB::table('products')->where('categories_id', $cat->id)->exists()) {
                if (session('receipt.service') == 'takeout') { // テイクアウトのみ
                    $products[$cat->id] = DB::table('products')->where([
                        ['categories_id', $cat->id],
                        ['takeout_flag', 1],
                    ])
                    ->whereIn('status', ['public', 'reserve'])
                    ->orderBy('sort_id', 'asc')->get();
                } elseif (session('receipt.service') == 'delivery') { // デリバリーのみ
                    $products[$cat->id] = DB::table('products')->where([
                        ['categories_id', $cat->id],
                        ['delivery_flag', 1],
                    ])
                    ->whereIn('status', ['public', 'reserve'])
                    ->orderBy('sort_id', 'asc')->get();
                } elseif (session('receipt.service') == 'ec') { // お取り寄せのみ
                    $products[$cat->id] = DB::table('products')->where([
                        ['categories_id', $cat->id],
                        ['ec_flag', 1],
                    ])
                    ->whereIn('status', ['public', 'reserve'])
                    ->orderBy('sort_id', 'asc')->get();
                } else { // 全て
                    $products[$cat->id] = DB::table('products')
                    ->where('categories_id', $cat->id)
                    ->whereIn('status', ['public', 'reserve'])
                    ->orderBy('sort_id', 'asc')->get();
                }
            }
        }

        // 在庫取得
        $stocks = [];
        if (session('receipt.date') != null) {
            $receipt_date = session('receipt.date');
            foreach ($products as $key => $product) {
                foreach ($product as $key => $item) {
                    // 設定在庫の取得
                    if (DB::table('stocks')->where('products_id', $item->id)->where('date', $receipt_date)->exists()) {
                        $now_stock = DB::table('stocks')->where(['products_id'=>$item->id, 'date'=>$receipt_date])->first()->stock;
                    } else {
                        $now_stock = DB::table('products')->find($item->id)->stock;
                    }
                    // 購入済み在庫の取得
                    if (DB::table('stock_customers')->where(['products_id'=>$item->id, 'date'=>$receipt_date])->exists()) {
                        $customers_stock = (int)DB::table('stock_customers')->where(['products_id'=>$item->id, 'date'=>$receipt_date])->sum('stock');
                    } else {
                        $customers_stock = 0;
                    }
                    $stocks[$item->id] = $now_stock - $customers_stock; // 残りの在庫計算
                }
            }
        }

        // 非表示フラグ
        if ($request->has('stop_flag') && $request->stop_flag === true) {
            $stop_flag = true;
        } else {
            $stop_flag = false;
        }

        return view('shop.home', [
            'shops' => $shops,
            'slides' => $slides,
            'categories' => $categories,
            'options' => $options,
            'products' => $products,
            'posts' => $posts,
            'stocks' => $stocks,
            'stop_flag' => $stop_flag,
        ]);
    }

    // 受け取り設定
    public function set_service(Request $request)
    {
        $request->session()->put('receipt.service', $request['service']);
        try {
            $request->session()->forget('receipt.shop_id');
            $request->session()->forget('receipt.shop_name');
            $request->session()->forget('receipt.date');
            $request->session()->forget('receipt.time');
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $request['service'];
    }

    // 受け取り方法わたし
    public function reset_session()
    {
        session()->forget('receipt');
    }

    // 受け取り方法わたし
    public function get_service()
    {
        return session('receipt.service');
    }

    // 受け取り店舗保存
    public function set_select_shop(Request $request)
    {
        $shop = DB::table('shops')->find($request['delivery_shop']);
        $request->session()->put('receipt.shop_id', $shop->id);
        $request->session()->put('receipt.shop_name', $shop->name);

        return $request['delivery_shop'];
    }

    // 営業時間取得
    public function get_business_time($account, Request $request)
    {
        $week_str = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

        $service = session('receipt.service');
        $inputs_week = date('w', strtotime($request['date']));
        $inputs_date = date('Y-m-d', strtotime($request['date']));
        $sub_domain = $account;

        if ($service == 'takeout') { // テイクアウト時
            $shop = DB::table('shops')->find(session('receipt.shop_id'));
            $preparation = $shop->takeout_preparation;
            $business_time = $shop->{$service.'_'.$week_str[$inputs_week]}; // 営業時間
        } elseif ($service == 'delivery') { // デリバリー時
            $sub_domain = $account;
            $manages = DB::table('manages')->where('domain', $sub_domain)->first();
            $preparation = $manages->delivery_preparation;
            $business_time = $manages->{$service.'_'.$week_str[$inputs_week]}; // 営業時間
        } else { // EC時
            $url = $_SERVER['HTTP_HOST'];
            $domain_array = explode('.', $url);
            $sub_domain = $domain_array[0];
            $inputs_date = date('Y-m-d');
            $manages = DB::table('manages')->where('domain', $sub_domain)->first();
            $ec_min_days = $manages->ec_min_days;
            $ec_delivery_time = explode("\n", $manages->ec_delivery_time); // 配送時間
        }

        $opt_html = ""; // option HTML
        if ($service != 'ec') { // デリバリーとテイクアウト
            if ($business_time != null) {
                $business_time_start = explode(',', $business_time)[0]; // 開始時間
                $business_time_end = explode(',', $business_time)[1]; // 終了時間
                for ($i = explode(':', $business_time_start)[0]; $i <= explode(':', $business_time_end)[0]; $i++) {
                    for ($j = 0; $j <= 45; $j+=15) {
                        if ($inputs_date == date('Y-m-d')) {
                            if (strtotime(date('Y-m-d H:i', strtotime("+".$preparation." minute"))) > strtotime($inputs_date.' '.$i.':'.$j) || strtotime($business_time_start) > strtotime($i.':'.$j)) {
                                continue;
                            } else {
                                if (strtotime($business_time_end) < strtotime($i.':'.$j) || strtotime($business_time_start) > strtotime($i.':'.$j)) {
                                    continue;
                                } else {
                                    $opt_html .= '<option value="'.date('H:i', strtotime($i.':'.$j)).'">'.date('H:i', strtotime($i.':'.$j)).'</option>';
                                }
                            }
                        } else {
                            if (strtotime($business_time_end) < strtotime($i.':'.$j) || strtotime($business_time_start) > strtotime($i.':'.$j)) {
                                continue;
                            } else {
                                $opt_html .= '<option value="'.date('H:i', strtotime($i.':'.$j)).'">'.date('H:i', strtotime($i.':'.$j)).'</option>';
                            }
                        }
                    }
                }
                $business_time_start = explode(',', $business_time)[2]; // 開始時間
                $business_time_end = explode(',', $business_time)[3]; // 終了時間
                for ($i = explode(':', $business_time_start)[0]; $i <= explode(':', $business_time_end)[0]; $i++) {
                    for ($j = 0; $j <= 45; $j+=15) {
                        if ($inputs_date == date('Y-m-d')) {
                            if (strtotime(date('Y-m-d H:i', strtotime("+".$preparation." minute"))) > strtotime($inputs_date.' '.$i.':'.$j) || strtotime($business_time_start) > strtotime($i.':'.$j)) {
                                continue;
                            } else {
                                if (strtotime($business_time_end) < strtotime($i.':'.$j) || strtotime($business_time_start) > strtotime($i.':'.$j)) {
                                    continue;
                                } else {
                                    $opt_html .= '<option value="'.date('H:i', strtotime($i.':'.$j)).'">'.date('H:i', strtotime($i.':'.$j)).'</option>';
                                }
                            }
                        } else {
                            if (strtotime($business_time_end) < strtotime($i.':'.$j) || strtotime($business_time_start) > strtotime($i.':'.$j)) {
                                continue;
                            } else {
                                $opt_html .= '<option value="'.date('H:i', strtotime($i.':'.$j)).'">'.date('H:i', strtotime($i.':'.$j)).'</option>';
                            }
                        }
                    }
                }
            }
            if ($opt_html === '') {
                $opt_html = '<option value="">ご注文受け付け時間外です</option>';
            }
            return ["service_flag" => true, "time" => $opt_html];
        } else { // EC時
            foreach ($ec_delivery_time as $key => $val) {
                $opt_html .= '<option value="'.$val.'">'.$val.'</option>';
            }
            $min_date = date('Y-m-d', strtotime('+'.$ec_min_days.' days'));
            if (strtotime($request['date']) >= strtotime($min_date)) {
                $taget_date = $request['date'];
            } else {
                $taget_date = $min_date;
            }
            return ["service_flag" => false, "time" => $opt_html, "min_days" => $ec_min_days, 'taget_date' => $taget_date];
        }
    }

    // 受け取り時間保存
    public function set_select_time(Request $request)
    {
        $request->session()->put('receipt.date', $request['date']);
        $request->session()->put('receipt.time', $request['time']);
    }

    // 受け取り設定の変更
    public function change_receipt($account, Request $request)
    {
        $request->session()->put('receipt.service', $request['service']);
        $request->session()->put('receipt.date', $request['delivery_date']);
        $request->session()->put('receipt.time', $request['delivery_time']);

        if ($request['delivery_shop'] == '店舗を選択' || $request['delivery_shop'] == null || $request['delivery_shop'] == '') {
            $request->session()->put('receipt.shop_id', null);
            $request->session()->put('receipt.shop_name', null);
        } else {
            $request->session()->put('receipt.shop_id', explode(':', $request['delivery_shop'])[0]);
            $request->session()->put('receipt.shop_name', explode(':', $request['delivery_shop'])[1]);
        }

        return redirect()->route('shop.home', ['account' => $account]);
    }

    // カート挿入
    public function addcart(Request $request)
    {
        // product_id：商品ID、quantity：数量、options：オプションID
        $product = DB::table('products')->where('id', $request['product_id'])->first();

        if ($request->session()->has('cart.amount')) {
            $amount = $request->session()->get('cart.amount')+0;
        } else {
            $amount = 0;
        }

        if ($request->session()->has('cart.total')) {
            $total = $request->session()->get('cart.total')+0;
        } else {
            $total = 0;
        }

        $price = $product->price;
        if (is_array($request['options'])) {
            foreach ($request['options'] as $key => $option) {
                $opt_temp = DB::table('options')->find($option);
                $price += $opt_temp->price;
            }
        }
        $price *= ($request['quantity']+0);
        // 商品保存
        $request->session()->push('cart.products', [
            'id' => $request['product_id'],
            'quantity' => $request['quantity']+0,
            'options' => $request['options'],
        ]);
        $request->session()->put('cart.amount', ($amount+$price));
        $request->session()->put('cart.total', ($total+=1));

        return [
            'amount' => session('cart.amount'),
            'total' => session('cart.total'),
        ];
    }
}
