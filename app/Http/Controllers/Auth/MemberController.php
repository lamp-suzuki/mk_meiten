<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.member');
    }

    public function edit(Request $request)
    {
        return view('auth.edit');
    }

    public function orders()
    {
        $id = Auth::id();
        $user_orders = [];
        $orders = DB::table('orders')
        ->where('users_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        foreach ($orders as $key => $order) {
            $products = [];
            $options = [];
            foreach (json_decode($order->carts) as $key => $cart) {
                $temp_product = DB::table('products')->find($cart->product_id);
                $total_price = $temp_product->price;
                foreach ($cart->options as $key => $option) {
                    $temp_option = DB::table('options')->find($option);
                    $options[] = [
                        'name' => $temp_option->name,
                        'price' => $temp_option->price,
                    ];
                    $total_price += $temp_option->price;
                }
                $products[] = [
                    'name' => $temp_product->name,
                    'thumbnail' => $temp_product->thumbnail_1,
                    'quantity' => $cart->quantity,
                    'total_price' => $total_price*$cart->quantity,
                    'options' => $options,
                ];
            }
            $user_orders[] = [
                'id' => $order->id,
                'service' => $order->service,
                'total_amount' => $order->total_amount,
                'okimochi' => $order->okimochi,
                'delivery_time' => $order->delivery_time,
                'products' => $products,
            ];
        }

        // dd($user_orders);

        return view('auth.orders', [
            'orders' => $user_orders,
        ]);
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name1' => 'required',
            'name2' => 'required',
            'furi1' => 'required',
            'furi2' => 'required',
            'email' => 'required|email',
            'email' => 'required|email|confirmed',
            'tel' => 'required',
            'zipcode' => 'alpha_dash',
        ])->validate();
        $id = Auth::id();
        try {
            DB::table('users')->where('id', $id)->update([
                'name' => $request['name1'].' '.$request['name2'],
                'furigana' => $request['furi1'].' '.$request['furi2'],
                'furigana' => $request['furi1'].' '.$request['furi2'],
                'email' => $request['email'],
                'tel' => $request['tel'],
                'zipcode' => $request['zipcode'],
                'pref' => $request['pref'],
                'address1' => $request['address1'],
                'address2' => $request['address2'],
            ]);
            session()->flash('message', '会員情報が更新されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('member.index');
    }

    public function again_order(Request $request)
    {
        if (isset($request['orders_id'])) {
            $orders = DB::table('orders')->find($request['orders_id']);
            $shops = DB::table('shops')->find($orders->shops_id);

            // service
            if ($orders->service == 'お持ち帰り') {
                $request->session()->put('receipt.service', 'takeout');
            } elseif ($orders->service == 'デリバリー') {
                $request->session()->put('receipt.service', 'delivery');
            } else {
                $request->session()->put('receipt.service', 'ec');
            }

            // ショップ
            $request->session()->put('receipt.shop_id', $shops->id);
            $request->session()->put('receipt.shop_name', $shops->name);

            // カート
            $amount = 0;
            foreach (json_decode($orders->carts) as $key => $cart) {
                $temp_product = DB::table('products')->find($cart->product_id);
                $total_price = $temp_product->price;
                foreach ($cart->options as $key => $option) {
                    $temp_option = DB::table('options')->find($option);
                    $options[] = $temp_option->id;
                    $total_price += $temp_option->price;
                }
                $products[] = [
                    'id' => $temp_product->id,
                    'quantity' => $cart->quantity,
                    'options' => $options,
                ];
                $amount += $total_price*$cart->quantity;
            }
            $request->session()->put('cart', [
                "products" => $products,
                "amount" => $amount,
                "total" => count($products),
                "shipping" => 0,
            ]);

            return redirect()->route('shop.home');
        }
    }
}
