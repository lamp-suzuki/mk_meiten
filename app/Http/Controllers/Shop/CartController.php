<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account, Request $request)
    {
        $sub_domain = $account;
        $manages = DB::table('manages')->where('domain', $sub_domain)->first();
        $shops = DB::table('shops')->where('manages_id', $manages->id)->get();

        // 送料設定
        if (session()->has('receipt.service') && session('receipt.service') != 'takeout') {
            if ($manages->{session('receipt.service').'_shipping_free'} <= session('cart.amount')) {
                session()->put('cart.shipping', 0);
            } else {
                session()->put('cart.shipping', $manages->{session('receipt.service').'_shipping'});
            }
            // 最低購入金額
            if (session('receipt.service') == 'delivery') {
                $delivery_shipping_min = $manages->delivery_shipping_min;
            } else {
                $delivery_shipping_min = null;
            }
        } else {
            session()->put('cart.shipping', 0);
            $delivery_shipping_min = null;
        }

        $products = [];
        $products_stocks = [];
        $options = [];
        // カート商品取得
        if (session('cart.products') !== null) {
            $cart_products = session('cart.products');
            $items_count = 0;
            foreach (session('cart.products') as $index => $product) {
                $items_count += (int)$product['quantity'];
                // 設定在庫の取得
                if (DB::table('stocks')->where(['products_id'=>$product['id'], 'date'=>session('receipt.date')])->exists()) {
                    $now_stock = DB::table('stocks')->where(['products_id'=>$product['id'], 'date'=>session('receipt.date')])->first()->stock;
                } else {
                    $now_stock = DB::table('products')->find($product['id'])->stock;
                }

                // 購入済み在庫の取得
                if (DB::table('stock_customers')->where(['products_id'=>$product['id'], 'date'=>session('receipt.date')])->exists()) {
                    $customers_stock = (int)DB::table('stock_customers')->where(['products_id'=>$product['id'], 'date'=>session('receipt.date')])->sum('stock');
                } else {
                    $customers_stock = 0;
                }

                $products[$index] = [
                    'data' => DB::table('products')->find($product['id']),
                    'stock' => $now_stock - $customers_stock // 残りの在庫数
                ];
                if (!isset($products_stocks[$product['id']])) {
                    $products_stocks[$product['id']] = $now_stock - $customers_stock - (int)$product['quantity'];
                } else {
                    $products_stocks[$product['id']] -= (int)$product['quantity'];
                }
                if (isset($products_stocks[$product['id']]) && $products_stocks[$product['id']] < 0) {
                    $flag = DB::table('products')->find($product['id']);
                    session()->put('cart.valistock', 'bad');
                    session()->put('cart.valistock_product', $flag->name);
                } elseif(isset($products_stocks[$product['id']]) && $products_stocks[$product['id']] >= 0) {
                    session()->forget('cart.valistock', 'bad');
                    session()->forget('cart.valistock_product');
                }

                // 金額計算
                $temp_price = 0;
                if ($product['options'] !== null) {
                    foreach ($product['options'] as $key => $opt) {
                        $temp = DB::table('options')->find($opt);
                        $temp_price += $temp->price;
                        $options[$index]['name'][] = $temp->name;
                    }
                    $options[$index]['price'] = $temp_price;
                }
            }

            foreach ($cart_products as $key => $product) {
                $flag = DB::table('products')->find($product['id']);
                if ($flag->{session('receipt.service').'_flag'} == 0) {
                    session()->put('cart.vali', 'bad');
                    session()->put('cart.vali_product', $flag->name);
                    break;
                } else {
                    if (session()->has('cart.vali')) {
                        session()->forget('cart.vali');
                        session()->forget('cart.vali_product');
                    }
                }
            }
            if (count($cart_products) < 1) {
                if (session()->has('cart.vali')) {
                    session()->forget('cart.vali');
                    session()->forget('cart.vali_product');
                }
            }
        }

        return view('shop.cart', [
            'manages' => $manages,
            'products' => $products,
            'products_stocks' => $products_stocks,
            'options' => $options,
            'shops' => $shops,
            'delivery_shipping_min' => $delivery_shipping_min,
            'items_count' => $items_count,
        ]);
    }

    // カート商品削除
    public function delete($account, Request $request)
    {
        $target = session('cart.products.'.(int)$request['product_id']);
        $product = DB::table('products')->find($target['id']);
        $price = $product->price;
        if (is_array($target['options'])) {
            foreach ($target['options'] as $key => $option) {
                $opt_temp = DB::table('options')->find($option);
                $price += $opt_temp->price;
            }
        }
        $price *= $target['quantity'];

        $request->session()->put('cart.amount', session('cart.amount') - $price);
        $request->session()->put('cart.total', session('cart.total') - 1);

        $request->session()->forget('cart.products.'.$request['product_id']);

        return redirect()->route('shop.cart', ['account' => $account]);
    }

    // カート商品数量変更
    public function change_quantity(Request $request)
    {
        $old_price = (int)$request['price'] * (int)$request['old_quantity'];
        $old_amount = (int)session('cart.amount');
        session()->put('cart.products.'.$request['index'].'.quantity', (int)$request['quantity']);
        session()->put('cart.amount', (int)$request['quantity'] * (int)$request['price'] + ($old_amount - $old_price));
    }

    // カート商品購入可能精査
    public function cart_vali()
    {
        $service = session('receipt.service');
        $cart_products = session('cart.products');
        foreach ($cart_products as $key => $product) {
            $flag = DB::table('products')->find($product['id']);
            if ($flag->{$service.'_flag'} == 0) {
                session()->put('cart.vali', 'bad');
                break;
            } else {
                if (session()->has('cart.vali')) {
                    session()->forget('cart.vali');
                }
            }
        }

        if (session()->has('cart.vali')) {
            return 'bad';
        } else {
            return 'ok';
        }
    }
}
