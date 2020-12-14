<?php

namespace App\Http\Controllers\Manage\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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

    public function index()
    {
        $manage = Auth::guard('manage')->user();

        return view('manage.setting.service', [
            'manage' => $manage,
        ]);
    }

    // テイクアウト設定
    public function takeout_update($account, Request $request)
    {
        $manage = Auth::guard('manage')->user();
        try {
            DB::table('manages')->where('id', $manage->id)->update([
                'takeout_cancel' => $request['cancelTakeout']
            ]);
            session()->flash('message', '更新されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。'.$th);
        }
        return redirect()->route('manage.setting.service.index', ['account' => $account]);
    }

    // デリバリー設定
    public function delivery_update($account, Request $request)
    {
        $manage = Auth::guard('manage')->user();
        try {
            foreach ($this->weeks as $id => $week) {
                if ($request['delivery_'.$id] != null) {
                    ${'delivery_'.$id} =
                    $request['delivery_lunch_start_hours_'.$id].':'.$request['delivery_lunch_start_seconds_'.$id].','.
                    $request['delivery_lunch_end_hours_'.$id].':'.$request['delivery_lunch_end_seconds_'.$id].','.
                    $request['delivery_dinner_start_hours_'.$id].':'.$request['delivery_dinner_start_seconds_'.$id].','.
                    $request['delivery_dinner_end_hours_'.$id].':'.$request['delivery_dinner_end_seconds_'.$id];
                } else {
                    ${'delivery_'.$id} = null;
                }
            }
            DB::table('manages')->where('id', $manage->id)->update([
                'delivery_cancel' => $request['cancelDelivery'],
                'delivery_shipping' => $request['delivery_shipping'],
                'delivery_shipping_min' => $request['delivery_shipping_min'],
                'delivery_shipping_free' => $request['delivery_shipping_free'],
                'delivery_area' => $request['delivery_area'],
                'delivery_preparation' => $request['delivery_preparation'],
                'delivery_sun' => $delivery_sun,
                'delivery_mon' => $delivery_mon,
                'delivery_tue' => $delivery_tue,
                'delivery_wed' => $delivery_wed,
                'delivery_thu' => $delivery_thu,
                'delivery_fri' => $delivery_fri,
                'delivery_sat' => $delivery_sat,
            ]);
            session()->flash('message', '更新されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。'.$th);
        }
        return redirect()->route('manage.setting.service.index', ['account' => $account]);
    }

    // お取り寄せ設定
    public function ec_update($account, Request $request)
    {
        $manage = Auth::guard('manage')->user();
        try {
            DB::table('manages')->where('id', $manage->id)->update([
                'ec_delivery_time' => $request['ec_delivery_time'],
                'ec_shipping' => $request['ec_shipping'],
                'ec_shipping_free' => $request['ec_shipping_free'],
                'ec_min_days' => $request['ec_min_days'],
            ]);
            session()->flash('message', '更新されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。'.$th);
        }
        return redirect()->route('manage.setting.service.index', ['account' => $account]);
    }
}
