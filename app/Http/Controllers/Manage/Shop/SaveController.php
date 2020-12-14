<?php

namespace App\Http\Controllers\Manage\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveController extends Controller
{
    public function index($account, Request $request)
    {
        $manage = Auth::guard('manage')->user();
        $payment = '';
        if ($request->has('payment1')) {
            $payment .= $request['payment1'].',';
        }
        if ($request->has('payment2')) {
            $payment .= $request['payment2'].',';
        }

        if ($request->has('action') && $request->has('shops_id')) {
            try {
                DB::table('shops')->where('id', $request['shops_id'])->update([
                    'name' => $request['name'],
                    'tel' => $request['tel'],
                    'email' => $request['email'],
                    'zipcode' => $request['zipcode'],
                    'pref' => $request['pref'],
                    'address1' => $request['address1'],
                    'address2' => $request['address2'],
                    'access' => $request['access'],
                    'googlemap_url' => $request['googlemap_url'],
                    'payment' => $payment,
                    'parking' => $request['parking'],
                    // 営業時間
                    'takeout_sun' => isset($request['takeout_sun']) ? $request['takeout_sun'] : null,
                    'takeout_mon' => isset($request['takeout_mon']) ? $request['takeout_mon'] : null,
                    'takeout_tue' => isset($request['takeout_tue']) ? $request['takeout_tue'] : null,
                    'takeout_wed' => isset($request['takeout_wed']) ? $request['takeout_wed'] : null,
                    'takeout_thu' => isset($request['takeout_thu']) ? $request['takeout_thu'] : null,
                    'takeout_fri' => isset($request['takeout_fri']) ? $request['takeout_fri'] : null,
                    'takeout_sat' => isset($request['takeout_sat']) ? $request['takeout_sat'] : null,
                    'takeout_preparation' => isset($request['takeout_preparation']) ? $request['takeout_preparation'] : 30,
                    // 'delivery_sun' => isset($request['delivery_sun']) ? $request['delivery_sun'] : null,
                    // 'delivery_mon' => isset($request['delivery_mon']) ? $request['delivery_mon'] : null,
                    // 'delivery_tue' => isset($request['delivery_tue']) ? $request['delivery_tue'] : null,
                    // 'delivery_wed' => isset($request['delivery_wed']) ? $request['delivery_wed'] : null,
                    // 'delivery_thu' => isset($request['delivery_thu']) ? $request['delivery_thu'] : null,
                    // 'delivery_fri' => isset($request['delivery_fri']) ? $request['delivery_fri'] : null,
                    // 'delivery_sat' => isset($request['delivery_sat']) ? $request['delivery_sat'] : null,
                    // 'delivery_preparation' => isset($request['delivery_preparation']) ? $request['delivery_preparation'] : 60,
                    // 'delivery_shipping' => isset($request['delivery_shipping']) ? $request['delivery_shipping'] : 0,
                    // 'delivery_shipping_free' => isset($request['delivery_shipping_free']) ? $request['delivery_shipping_free'] : null,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                session()->flash('message', '店舗情報が更新されました。');
            } catch (\Throwable $th) {
                session()->flash('error', 'エラーが発生しました。');
            }
            return redirect()->route('manage.shop.index', ['account' => $account]);
        } else {
            try {
                DB::table('shops')->insert([
                    'manages_id' => $manage->id,
                    'name' => $request['name'],
                    'tel' => $request['tel'],
                    'email' => $request['email'],
                    'zipcode' => $request['zipcode'],
                    'pref' => $request['pref'],
                    'address1' => $request['address1'],
                    'address2' => $request['address2'],
                    'access' => $request['access'],
                    'googlemap_url' => $request['googlemap_url'],
                    'payment' => $payment,
                    'parking' => $request['parking'],
                    // 営業時間
                    'takeout_sun' => isset($request['takeout_sun']) ? $request['takeout_sun'] : null,
                    'takeout_mon' => isset($request['takeout_mon']) ? $request['takeout_mon'] : null,
                    'takeout_tue' => isset($request['takeout_tue']) ? $request['takeout_tue'] : null,
                    'takeout_wed' => isset($request['takeout_wed']) ? $request['takeout_wed'] : null,
                    'takeout_thu' => isset($request['takeout_thu']) ? $request['takeout_thu'] : null,
                    'takeout_fri' => isset($request['takeout_fri']) ? $request['takeout_fri'] : null,
                    'takeout_sat' => isset($request['takeout_sat']) ? $request['takeout_sat'] : null,
                    'takeout_preparation' => isset($request['takeout_preparation']) ? $request['takeout_preparation'] : 30,
                    // 'delivery_sun' => isset($request['delivery_sun']) ? $request['delivery_sun'] : null,
                    // 'delivery_mon' => isset($request['delivery_mon']) ? $request['delivery_mon'] : null,
                    // 'delivery_tue' => isset($request['delivery_tue']) ? $request['delivery_tue'] : null,
                    // 'delivery_wed' => isset($request['delivery_wed']) ? $request['delivery_wed'] : null,
                    // 'delivery_thu' => isset($request['delivery_thu']) ? $request['delivery_thu'] : null,
                    // 'delivery_fri' => isset($request['delivery_fri']) ? $request['delivery_fri'] : null,
                    // 'delivery_sat' => isset($request['delivery_sat']) ? $request['delivery_sat'] : null,
                    // 'delivery_preparation' => isset($request['delivery_preparation']) ? $request['delivery_preparation'] : 60,
                    // 'delivery_shipping' => isset($request['delivery_shipping']) ? $request['delivery_shipping'] : 0,
                    // 'delivery_shipping_free' => isset($request['delivery_shipping_free']) ? $request['delivery_shipping_free'] : null,
                    'updated_at' => now(),
                ]);
                session()->flash('message', '店舗情報が更新されました。');
            } catch (\Throwable $th) {
                session()->flash('error', 'エラーが発生しました。');
            }
            return redirect()->route('manage.shop.index', ['account' => $account]);
        }
    }
}
