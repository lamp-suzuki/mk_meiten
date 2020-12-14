<?php

namespace App\Http\Controllers\Manage\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $manage = Auth::guard('manage')->user();
        $orders = DB::table('orders')->where('manages_id', $manage->id);
        // キーワード検索
        if ($request->has('ketwords') && $request->ketwords != '') {
            $orders->where('service', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('name', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('furigana', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('email', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('tel', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('zipcode', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('pref', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('address1', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('address2', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('memo', 'LIKE', "%{$request->ketwords}%");
        }

        // 期間指定
        if ($request->has('period')) {
            switch ($request->period) {
                case 'today':
                    $orders->whereDate('created_at', date('Y-m-d'));
                    break;
                case 'lastday':
                    $orders->whereDate('created_at', date('Y-m-d', strtotime('-1 days')));
                    break;
                case 'thismonth':
                    $orders->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
                    break;
                case 'lastmonth':
                    $orders->whereYear('created_at', date('Y', strtotime('-1 months')))->whereMonth('created_at', date('m', strtotime('-1 months')));
                    break;
                // 配達
                case 'deli-lastday':
                    $orders
                    ->where('service', 'デリバリー')
                    ->whereDate('delivery_time', date('Y-m-d' , strtotime('-1 days')));
                    break;
                case 'deli-today':
                    $orders
                    ->where('service', 'デリバリー')
                    ->whereDate('delivery_time', date('Y-m-d'));
                    break;
                case 'deli-tomorrow':
                    $orders
                    ->where('service', 'デリバリー')
                    ->whereDate('delivery_time', date('Y-m-d', strtotime('+1 days')));
                    break;
                case 'deli-after-tomorrow':
                    $orders
                    ->where('service', 'デリバリー')
                    ->whereDate('delivery_time', date('Y-m-d', strtotime('+2 days')));
                    break;

                default:
                break;
            }
        }

        $result = $orders->orderByDesc('created_at')->paginate(50);

        return view('manage.order.index', [
            'orders' => $result,
            'request' => $request
        ]);
    }

    public function download($account, Request $request)
    {
        $response = new StreamedResponse(function () use ($request) {
            $manage = Auth::guard('manage')->user();
            $orders = DB::table('orders')->where([
                'manages_id' => $manage->id,
                'cancel' => 0,
            ]);

            // キーワード検索
            if ($request->has('ketwords') && $request->ketwords != '') {
                $orders->where('service', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('name', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('furigana', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('email', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('tel', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('zipcode', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('pref', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('address1', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('address2', 'LIKE', "%{$request->ketwords}%")
                    ->orWhere('memo', 'LIKE', "%{$request->ketwords}%");
            }

            // 期間指定
            if ($request->has('period')) {
                switch ($request->period) {
                    case 'today':
                        $orders->whereDate('created_at', date('Y-m-d'));
                        break;
                    case 'lastday':
                        $orders->whereDate('created_at', date('Y-m-d', strtotime('-1 days')));
                        break;
                    case 'thismonth':
                        $orders->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
                        break;
                    case 'lastmonth':
                        $orders->whereYear('created_at', date('Y', strtotime('-1 months')))->whereMonth('created_at', date('m', strtotime('-1 months')));
                        break;
                    // 配達
                    case 'deli-lastday':
                        $orders
                        ->where('service', 'デリバリー')
                        ->whereDate('delivery_time', date('Y-m-d' , strtotime('-1 days')));
                        break;
                    case 'deli-today':
                        $orders
                        ->where('service', 'デリバリー')
                        ->whereDate('delivery_time', date('Y-m-d'));
                        break;
                    case 'deli-tomorrow':
                        $orders
                        ->where('service', 'デリバリー')
                        ->whereDate('delivery_time', date('Y-m-d', strtotime('+1 days')));
                        break;
                    case 'deli-after-tomorrow':
                        $orders
                        ->where('service', 'デリバリー')
                        ->whereDate('delivery_time', date('Y-m-d', strtotime('+2 days')));
                        break;
                    default:
                    break;
                }
            }

            $results = $orders->orderByDesc('id')->get();

            $stream = fopen('php://output', 'w');
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            fputcsv($stream, [
                '注文番号',
                '受け取り方法',
                '受け取り店舗',
                '注文日時',
                'お名前',
                'フリガナ',
                '電話番号',
                'メールアドレス',
                '合計金額',
                '決済方法',
                '受け取り日時',
                'お届け先',
                '商品名',
                '個数',
            ]);

            foreach ($results as $index => $result) {
                $line = [];
                $line = [
                    date('ymdHis', strtotime($result->created_at)), // 番号
                    $result->service, // 受け取り方法
                    $result->service == '店舗受け取り' ? DB::table('shops')->find($result->shops_id)->name : '', // 受け取り店舗
                    date('Y/m/d H:i:s', strtotime($result->created_at)), // 注文日時
                    $result->name, // お名前
                    $result->furigana, // フリガナ
                    '"'.$result->tel.'"', // 電話番号
                    $result->email, // メールアドレス
                    $result->total_amount, // 合計金額
                    $result->payment_method == 0 ? 'クレジット' : '現金払い', // 決済方法
                    $result->delivery_time, // 受け取り日時
                    $result->zipcode != null ? '〒'.$result->zipcode.' '.$result->pref.$result->address1.$result->address2 : '', // お届け先
                ];

                foreach (json_decode($result->carts) as $cart) {
                    $product_name = '';
                    $product_quantity = 0;
                    if (isset($cart->product_name)&&isset($cart->product_price)&&isset($cart->options_data)) {
                        $product_name = $cart->product_name;
                        $product_quantity = (int)$cart->quantity;
                        foreach ($cart->options_data as $option) {
                            if (isset($option[0]) && $option[0] != null) {
                                $product_name .= ' ['.$option[0].']';
                            }
                        }
                        $line[] = $product_name;
                        $line[] = $product_quantity;
                    } else {
                        $temp_product = DB::table('products')->find($cart->product_id);
                        if ($temp_product !== null) {
                            $product_name = $temp_product->name;
                            $product_quantity = (int)$cart->quantity;
                            foreach ($cart->options as $option) {
                                $temp_opt = DB::table('options')->find($option);
                                if ($temp_opt != null) {
                                    $product_name .= ' ['.$temp_opt->name.']';
                                }
                            }
                            $line[] = $product_name;
                            $line[] = $product_quantity;
                        }
                    }
                }
                fputcsv($stream, $line);
            }
            fclose($stream);
        });
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="orders_list.csv"');
        return $response;
    }
}
