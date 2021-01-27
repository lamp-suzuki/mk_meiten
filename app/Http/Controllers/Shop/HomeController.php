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

        $manages = DB::table('manages')->where('domain', $account)->first();
        $shops = DB::table('shops')->where('manages_id', $manages->id)->get();
        $slides = DB::table('slides')->where('manages_id', $manages->id)->first();
        $categories = DB::table('categories')->where('manages_id', $manages->id)->orderBy('sort_id', 'asc')->get();
        $posts = DB::table('posts')
            ->where('manages_id', $manages->id)
            ->whereDate('created_at', '<=', date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->first();

        // 念のため削除
        if (session('cart.products') == null || count(session('cart.products')) <= 0) {
            session()->forget('cart');
        }

        /* 商品情報取得 */
        $options = [];
        $products = [];
        foreach ($categories as $cat) {
            // オプション
            if (DB::table('options')->where('categories_id', $cat->id)->exists()) {
                $options[$cat->id] = DB::table('options')->where('categories_id', $cat->id)->get();
            }
            // 商品
            if (DB::table('products')->where('categories_id', $cat->id)->exists()) {
                $products[$cat->id] = DB::table('products')
                    ->where('categories_id', $cat->id)
                    ->whereIn('status', ['public', 'reserve']);
                if (session('receipt.date') != null) {
                    $products[$cat->id]->where(function ($query) {
                        $query->orWhere([
                                ['release_start', null],
                                ['release_end', null]
                            ])
                            ->orWhere([
                                ['release_start', '<=', session('receipt.date')],
                                ['release_end', '>=', session('receipt.date')]
                            ]);
                    });
                }
                if (session('receipt.service') == 'takeout') { // テイクアウトのみ
                    $products[$cat->id]->where('takeout_flag', 1);
                } elseif (session('receipt.service') == 'delivery') { // デリバリーのみ
                    $products[$cat->id]->where('delivery_flag', 1);
                } elseif (session('receipt.service') == 'ec') { // お取り寄せのみ
                    $products[$cat->id]->where('ec_flag', 1);
                }
                $products[$cat->id] = $products[$cat->id]->orderBy('sort_id', 'asc')->get();
            }
        }

        // 在庫取得
        $stocks = [];
        if (session('receipt.date') != null) {
            $receipt_date = session('receipt.date');
            foreach ($products as $product) {
                foreach ($product as $item) {
                    // 設定在庫の取得
                    if (DB::table('stocks')->where(['products_id'=>$item->id, 'date'=>$receipt_date])->exists()) {
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
        return $request['service'];
    }

    // 受け取り方法リセット
    public function reset_session()
    {
        session()->forget('receipt');
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
        $manages = DB::table('manages')->where('domain', $account)->first();

        $service = session('receipt.service');
        $inputs_date = date('Y-m-d', strtotime($request['date']));
        $inputs_week = date('w', strtotime($inputs_date));

        if ($service == 'takeout') { // テイクアウト時
            $shop = DB::table('shops')->find(session('receipt.shop_id'));
            $preparation = $shop->takeout_preparation;
            $business_time = $shop->{$service.'_'.$week_str[$inputs_week]}; // 営業時間
        } elseif ($service == 'delivery') { // デリバリー時
            $preparation = $manages->delivery_preparation;
            $business_time = $manages->{$service.'_'.$week_str[$inputs_week]}; // 営業時間
        } else { // EC時
            $ec_min_days = $manages->ec_min_days;
            $ec_delivery_time = explode("\n", $manages->ec_delivery_time); // 配送時間
        }

        $opt_html = ""; // option HTML
        if ($service != 'ec') { // デリバリーとテイクアウト
            if ($business_time != null) {
                // 受け渡し時間が日をまたいで無い時
                if (strtotime(date('Y-m-d', strtotime('+'.$preparation.' minute'))) <= strtotime($inputs_date.' 00:00:00')) {
                    $time_schedule = [];
                    $business_time_arr = explode(',', $business_time);
                    if ((isset($business_time_arr[0]) && $business_time_arr[0] != '') && (isset($business_time_arr[1]) && $business_time_arr[1] != '')) {
                        $time_schedule[] = [$business_time_arr[0], $business_time_arr[1]];
                    }
                    if ((isset($business_time_arr[2]) && $business_time_arr[2] != '') && (isset($business_time_arr[3]) && $business_time_arr[3] != '')) {
                        $time_schedule[] = [$business_time_arr[2], $business_time_arr[3]];
                    }
                    foreach ($time_schedule as $index => $val) {
                        // 正しく入力されていない場合はスキップ
                        if (!isset(explode(':', $val[0])[0]) || !isset(explode(':', $val[0])[1])) {
                            continue;
                        }
                        if ($val[0] === $val[1]) {
                            continue;
                        }
                        // 営業時間HTML生成
                        for ($i = explode(':', $val[0])[0]; $i <= explode(':', $val[1])[0]; $i++) {
                            for ($j = 0; $j <= 45; $j+=15) {
                                // 営業時間外の時
                                if ((strtotime($inputs_date.' '.$i.':'.$j) < strtotime($inputs_date.' '.$val[0])) || (strtotime($inputs_date.' '.$i.':'.$j) > strtotime($inputs_date.' '.$val[1]))) {
                                    continue;
                                }
                                // お受け取り時間前
                                if ($preparation % 1440 != 0) {
                                    if (strtotime("+".$preparation." minute") > strtotime($inputs_date.' '.$i.':'.$j)) {
                                        continue;
                                    }
                                }

                                $opt_html .= '<option value="'.date('H:i', strtotime($i.':'.$j)).'">'.date('H:i', strtotime($i.':'.$j)).'</option>'."\n";
                            }
                        }
                    }
                }
            }

            if ($opt_html === '') {
                $opt_html = '<option value="">ご注文受け付け時間外です</option>';
            }
            return ["service_flag" => true, "time" => $opt_html];

        // EC時
        } else {
            foreach ($ec_delivery_time as $val) {
                $opt_html .= '<option value="'.$val.'">'.$val.'</option>';
            }
            return ["service_flag" => false, "time" => $opt_html, "min_days" => $ec_min_days, 'inputs_date' => $inputs_date];
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
        $request->session()->put('receipt.shop_id', explode(':', $request['delivery_shop'])[0]);
        $request->session()->put('receipt.shop_name', explode(':', $request['delivery_shop'])[1]);
        $request->session()->put('receipt.date', $request['delivery_date']);
        $request->session()->put('receipt.time', $request['delivery_time']);

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
            foreach ($request['options'] as $option) {
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
