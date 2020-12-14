<?php

namespace App\Http\Controllers\Manage\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BasicController extends Controller
{
    public function index()
    {
        $manage = Auth::guard('manage')->user();
        $genres = DB::table('genres')->get();
        return view('manage.setting.basic', [
            'manage' => $manage,
            'genres' => $genres,
        ]);
    }

    // 更新
    public function update($account, Request $request)
    {
        $manage = Auth::guard('manage')->user();
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ])->validate();

        if ($request['logo'] != null) {
            $logo = $request->file('logo')->store('public/uploads/logo');
            $logo = str_replace('public', 'storage', $logo);
        } else {
            if ($request->has('logo_flag') && $request['logo'] == null) {
                $logo = $manage->logo;
            }
        }

        try {
            DB::table('manages')->where('id', $request['manage_id'])->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'tel' => $request['tel'],
                'fax' => $request['fax'],
                'description' => $request['description'],
                'logo' => isset($request['logo']) ? $logo : null,
                'genres_id' => $request['genres_id'],
                'default_tax' => $request['default_tax'],
                'takeout_flag' => isset($request['takeout_flag']) ? 1 : 0,
                'delivery_flag' => isset($request['delivery_flag']) ? 1 : 0,
                'ec_flag' => isset($request['ec_flag']) ? 1 : 0,
                'point_flag' => $request['point_flag'],
                'default_stock' => (int)$request['default_stock'],
                'alcohol_flag' => $request['alcohol_flag'],
                'facebook_url' => $request['facebook_url'],
                'twitter_url' => $request['twitter_url'],
                'instagram_url' => $request['instagram_url'],
                'updated_at' => now(),
            ]);
            session()->flash('message', '更新されました。');
        } catch (\Throwable $th) {
            dd($th);
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('manage.setting.basic', ['account' => $account]);
    }
}
