<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Twilio\Rest\Client; // Twilio

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderThanks;
use App\Mail\OrderAdmin;
use App\Mail\OrderFax;

class ThanksController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account, Request $request)
    {
        $sub_domain = $account;
        $manages = DB::table('manages')->where('domain', $sub_domain)->first(); // 店舗アカウント

        if (session('receipt.service') == 'takeout') {
            $service = '店舗受け取り';
            $services = 'takeout';
        } elseif (session('receipt.service') == 'delivery') {
            $service = 'デリバリー';
            $services = 'delivery';
        } else {
            $service = 'デリバリー';
            $services = 'ec';
        }

        // 商品情報
        $i = 0;
        $cart = [];
        $thumbnails = [];
        $notice_email = [];
        $notice_tel = [];
        $notice_fax = [];
        $data_total_amount = 0;
        while ($request->has('cart_'.$i.'_id')) {
            $options = [];
            $option_data = [];
            $data_product = DB::table('products')->find($request['cart_'.$i.'_id']);
            $category = DB::table('categories')->find($data_product->categories_id);
            if ($category->notice_email != null && $category->notice_email != '') {
                $notice_email[] = $category->notice_email;
            }
            if ($category->notice_tel != null && $category->notice_tel != '') {
                $notice_tel[] = $category->notice_tel;
            }
            if ($category->notice_fax != null && $category->notice_fax != '') {
                $notice_fax[] = $category->notice_fax;
            }

            if ($request['cart_'.$i.'_options'] !== null) {
                foreach (explode(',', $request['cart_'.$i.'_options']) as $opt_id) {
                    if ($opt_id != '') {
                        $options[] = (int)$opt_id;
                        $temp_opt = DB::table('options')->find((int)$opt_id);
                        $option_data[] = [$temp_opt->name, $temp_opt->price];
                    }
                }
            }
            $cart[] = [
                'product_id' => $request['cart_'.$i.'_id'],
                'product_name' => $data_product->name,
                'product_price' => $data_product->price,
                'quantity' => $request['cart_'.$i.'_quantity'],
                'options' => $options,
                'options_data' => $option_data,
            ];

            $thumbnails[] = $data_product->thumbnail_1;
            $data_price = 0;
            if (count($option_data) > 0) {
                foreach ($option_data as $o_data) {
                    $data_price += $o_data[1] * (int)$request['cart_'.$i.'_quantity'];
                }
            }
            $data_price += $data_product->price * (int)$request['cart_'.$i.'_quantity'];
            $data_total_amount += $data_price;

            $data['carts'][] = [
                'name' => $data_product->name,
                'quantity' => $request['cart_'.$i.'_quantity'],
                'price' => $data_product->price,
                'amount' => $data_price,
                'options' => $option_data,
            ];
            ++$i;
        }

        $notice_email = array_unique($notice_email);
        $notice_tel = array_unique($notice_tel);
        $notice_fax = array_unique($notice_fax);

        // 店舗ID設定
        if ($request['shop_id'] !== null) {
            $shop_info = DB::table('shops')->find($request['shop_id']);
            $shops_id = $shop_info->id;
            $shops_fax = $shop_info->fax;
            $twiml_shop = $shop_info->name;
        } else {
            $temp_shops = DB::table('shops')->where('manages_id', $manages->id)->first();
            $shop_info = null;
            $shops_id = $temp_shops->id;
            $shops_fax = $temp_shops->fax;
            $twiml_shop = null;
        }

        // 最終金額計算
        $total_amount = (int)($data_total_amount + (int)session('cart.shipping'));
        $use_points = 0;

        // 送料設定
        if ((int)session('cart.shipping') !== 0) {
            $shipping = (int)session('cart.shipping');
        } else {
            $shipping = 0;
        }

        $data['total_amount'] = $total_amount;
        $data['date_time'] = $request['delivery_time'];

        // 決済処理
        if (session('form_payment.pay') == 0) {
            if (session('form_payment.payjp-token') != null) {
                \Payjp\Payjp::setApiKey(config('app.payjpkey'));
                try {
                    $charge = \Payjp\Charge::create(array(
                        "card" => session('form_payment.payjp-token'),
                        "amount" => $total_amount,
                        "currency" => "jpy",
                        "capture" => true,
                        "description" => $manages->name,
                    ));
                } catch (\Throwable $th) {
                    session()->flash('error', 'クレジットカード決済ができませんでした。クレジットカード情報をご確認の上、再度お試しください。');
                    return redirect()->route('shop.confirm', ['account' => $account]);
                }
            } else {
                session()->flash('error', 'クレジットカード決済ができませんでした。クレジットカード情報をご確認の上、再度お試しください。');
                return redirect()->route('shop.confirm', ['account' => $account]);
            }
        }

        // 会員処理
        $users_id = null;
        $get_point = 0;

        // 注文データ作成
        try {
            $order_id = DB::table('orders')->insertGetId([
                'manages_id' => $manages->id,
                'shops_id' => $shops_id,
                'carts' => json_encode($cart),
                'service' => $service,
                'delivery_time' => $request['delivery_time'],
                'okimochi' => (isset($request['okimochi']) && $request['okimochi'] != null) ? $request['okimochi'] : 0,
                'shipping' => $shipping,
                'total_amount' => $total_amount,
                'payment_method' => $request['payment_method'],
                'users_id' => $users_id,
                'name' => $request['name'],
                'furigana' => $request['furigana'],
                'tel' => $request['tel'],
                'email' => $request['email'],
                'zipcode' => $request['zipcode'],
                'pref' => $request['pref'],
                'address1' => $request['address1'],
                'address2' => $request['address2'],
                'memo' => session('form_cart.other_content') != null ? session('form_cart.other_content') : null,
                'charge_id' => isset($charge) ? $charge->id : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            report($th);
            session()->flash('error', '決済処理に失敗しました。もう一度お試しください。');
            return redirect()->route('shop.confirm', ['account' => $account]);
        }

        // 在庫処理
        foreach ($cart as $item) {
            try {
                DB::table('stock_customers')->insert([
                    'manages_id' => $manages->id,
                    'products_id' => $item['product_id'],
                    'orders_id' => $order_id,
                    'shops_id' => $shops_id,
                    'stock' => (int)$item['quantity'],
                    'date' => date('Y-m-d', strtotime(session('receipt.date')))
                ]);
            } catch (\Throwable $th) {
                report($th);
            }
        }

        // メール用データ
        if ($request['payment_method'] == 0) {
            $payment_method = 'クレジットカード決済';
        } else {
            $payment_method = '店舗でお支払い';
        }
        $user = [
            'name' => $request['name'],
            'furigana' => $request['furigana'],
            'tel' => $request['tel'],
            'email' => $request['email'],
            'zipcode' => $request['zipcode'],
            'pref' => $request['pref'],
            'address1' => $request['address1'],
            'address2' => $request['address2'],
            'payment' => $payment_method,
            'receipt' => $request['set_receipt'] == 0 ? 'なし' : 'あり',
            'other' => session('form_cart.other_content') != null ? session('form_cart.other_content') : 'なし',
            'okimochi' => session('form_cart.okimochi'),
            'use_points' => $use_points,
            'get_point' => $get_point,
            'shipping' => $shipping,
        ];

        // セッション削除
        $request->session()->forget(['form_payment', 'form_cart', 'form_order', 'receipt', 'cart']);
        $request->session()->regenerateToken();

        // 電話の通知
        if ($manages->noti_tel != null) { // 電話番号があれば
            $tel_noti_flag = true;
            if ($manages->noti_start_time != null && $manages->noti_end_time != null) {
                if (strtotime($manages->noti_start_time) <= strtotime(date('H:i:s')) && strtotime($manages->noti_end_time) >= strtotime(date('H:i:s'))) {
                    $tel_noti_flag = true; // 指定の時間内
                } else {
                    $tel_noti_flag = false; // 指定の時間外
                }
            }
        } else {
            $tel_noti_flag = false;
        }
        $twiml = '<Response><Say language="ja-jp">こんにちは、テイクイーツです。';
        $twiml .= $request['furigana'].'様より';
        if ($twiml_shop != null) {
            $twiml .= $twiml_shop.'へ';
        }
        $twiml .= $service.'のご注文がございます。';
        $twiml .= '</Say></Response>';
        $sid = config("app.twilio_sid");
        $token = config("app.twilio_token");
        if ($tel_noti_flag && ($services == 'takeout' || $services == 'delivery')) {
            try {
                $twilio = new Client($sid, $token);
                $call = $twilio->calls
                        ->create(
                            toInternational($manages->noti_tel), // to
                            config("app.twilio_from"), // from
                            [
                                'phoneNumberSid' => config('app.twilio_phone_sid'),
                                'voice' => 'alice',
                                'language' => 'ja-JP',
                                'timeout' => 30,
                                'twiml' => $twiml,
                            ]
                        );
            } catch (\Throwable $th) {
                report($th);
            }
        }

        if (count($notice_tel) > 0) {
            foreach ($notice_tel as $telnum) {
                try {
                    $twilio = new Client($sid, $token);
                    $call = $twilio->calls
                            ->create(
                                toInternational($telnum), // to
                                config("app.twilio_from"), // from
                                [
                                    'phoneNumberSid' => config('app.twilio_phone_sid'),
                                    'voice' => 'alice',
                                    'language' => 'ja-JP',
                                    'timeout' => 30,
                                    'twiml' => $twiml,
                                ]
                            );
                } catch (\Throwable $th) {
                    report($th);
                }
            }
        }

        // メール送信
        // お客様
        try {
            $subject = '【'.$manages->name.'】ご注文内容のご確認';
            Mail::to($request['email'])->send(new OrderThanks($subject, $manages, $user, $shop_info, $service, $data));
        } catch (\Throwable $th) {
            report($th);
        }
        // 店舗様
        try {
            $subject_admin = '【TakeEats】お客様より'.$service.'のご注文がありました';
            $even_more_bcc = [ // bcc
                'takeeats2020@gmail.com'
            ];
            $even_more_bcc = array_merge($even_more_bcc, $notice_email);
            Mail::to($manages->email)
            ->bcc($even_more_bcc)
            ->send(new OrderAdmin($subject_admin, $manages, $user, $shop_info, $service, $data));
        } catch (\Throwable $th) {
            report($th);
        }
        // FAX
        if ($manages->fax != null && $manages->fax != '') {
            $tofax = str_replace('-', '', $manages->fax);
            try {
                Mail::to('fax843780@ecofax.jp')->send(new OrderFax($tofax, $manages, $user, $shop_info, $service, $data));
            } catch (\Throwable $th) {
                report($th);
            }
        }
        if (count($notice_fax) > 0) {
            foreach ($notice_fax as $faxnum) {
                $faxnum = str_replace('-', '', $faxnum);
                try {
                    Mail::to('fax843780@ecofax.jp')->send(new OrderFax($faxnum, $manages, $user, $shop_info, $service, $data));
                } catch (\Throwable $th) {
                    report($th);
                }
            }
        }

        return view('shop.thanks', [
            'order_id' => $order_id,
            'cart' => $cart,
            'date_time' => $request['delivery_time'],
            'total_amount' => $total_amount,
            'service' => $services,
            'thumbnails' => $thumbnails,
            'shop_info' => $shop_info,
            'get_point' => $get_point,
        ]);
    }
}
