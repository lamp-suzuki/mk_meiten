<?php

namespace App\Http\Controllers\Manage\Order;

use App\Http\Controllers\Controller;
use App\Mail\CancelOrder;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DetailController extends Controller
{
    public function index($account, $id)
    {
        $order = DB::table('orders')->find($id);
        $shop = DB::table('shops')->find($order->shops_id);

        $products = [];
        foreach (json_decode($order->carts) as $data) {
            if (isset($data->product_name)&&isset($data->product_price)&&isset($data->options_data)) {
                $options = [];
                $amount = 0;
                $amount += (int)$data->product_price;
                foreach ($data->options_data as $opt) {
                    $options[] = [
                        'name' => $opt[0],
                        'price' => $opt[1],
                    ];
                    $amount += (int)$opt[1];
                }
                $amount *= (int)$data->quantity;
                $products[] = [
                    'name' => $data->product_name,
                    'thumbnail' => null,
                    'quantity' => (int)$data->quantity,
                    'amount' => $amount,
                    'options' => $options,
                ];
            } else {
                $product = DB::table('products')->find($data->product_id);
                $options = [];
                $amount = 0;
                $amount += $product->price;
                foreach ($data->options as $key => $opt_id) {
                    $opt = DB::table('options')->find($opt_id);
                    if ($opt != null) {
                        $options[] = [
                            'name' => $opt->name,
                            'price' => $opt->price,
                        ];
                        $amount += $opt->price;
                    }
                }
                $amount *= (int)$data->quantity;
                $products[] = [
                    'name' => $product->name,
                    'thumbnail' => $product->thumbnail_1,
                    'quantity' => (int)$data->quantity,
                    'amount' => $amount,
                    'options' => $options,
                ];
            }
        }

        return view('manage.order.detail', [
            'order' => $order,
            'shop' => $shop,
            'products' => $products,
        ]);
    }

    public function cancel($account, $id, Request $request)
    {
        $orders = DB::table('orders')->find($id);

        // キャンセルフラグ処理
        try {
            DB::table('orders')
            ->where('id', $id)
            ->update([
                'cancel' => 1,
                'updated_at' => now(),
            ]);
            session()->flash('message', 'キャンセル処理が完了しました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'システムエラーが発生しました。');
        }

        // クレカ返金処理
        if ($orders->charge_id != null && $orders->charge_id != '') {
            try {
                \Payjp\Payjp::setApiKey(config('app.payjpkey'));
                $ch = \Payjp\Charge::retrieve($orders->charge_id);
                $ch->refund();
            } catch (\Throwable $th) {
                session()->flash('error', 'クレジットカード決済の返金に失敗しました。');
            }
        }

        // お客様メール送信
        $products = [];
        foreach (json_decode($orders->carts) as $data) {
            $product = DB::table('products')->find($data->product_id);
            if ($product !== null) {
                $options = 'オプション：';
                $amount = 0;
                $amount += $product->price;
                foreach ($data->options as $key => $opt_id) {
                    $opt = DB::table('options')->find($opt_id);
                    $options .= $opt->name.' ';
                    $amount += $opt->price;
                }
                $amount *= (int)$data->quantity;
                $products[] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => (int)$data->quantity,
                    'amount' => $amount,
                    'options' => $options,
                ];
            }
        }

        if ($orders->payment_method == 0) { // 決済方法
            $payment_method = 'クレジットカード決済';
        } elseif ($orders->payment_method == 1) {
            $payment_method = '現地でお支払い（現金）';
        } else {
            $payment_method = '現地でお支払い（PayPay）';
        }

        $users = [
            'name' => $orders->name,
            'furigana' => $orders->furigana,
            'email' => $orders->email,
            'tel' => $orders->tel,
            'zipcode' => $orders->zipcode,
            'pref' => $orders->pref,
            'tel' => $orders->tel,
            'address1' => $orders->address1,
            'address2' => $orders->address2,
            'memo' => $orders->memo,

            'products' => $products,
            'service' => $orders->service,
            'payment_method' => $payment_method,
            'delivery_time' => $orders->delivery_time,
            'shipping' => $orders->shipping,
            'total_amount' => $orders->total_amount,
        ];
        $manages = Auth::guard('manage')->user();
        try {
            $subject = '【'.$manages->name.'】注文キャンセルのお知らせ';
            Mail::to($users['email'])->send(new CancelOrder($subject, $manages, $users, $orders));
        } catch (\Throwable $th) {
            report($th);
        }

        return redirect()->route('manage.order.detail', ['account' => $account, 'id' => $id]);
    }
}
