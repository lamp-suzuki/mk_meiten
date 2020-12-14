<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConfirmController extends Controller
{
    public function index($account, Request $request)
    {
        // dd($request);
        Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required|integer',
            'lead_time' => 'required|integer',
        ])->validate();

        // 画像ファイル処理
        $thumbnails = [];
        for ($i=1; $i <= 3; $i++) {
            if ($request['thumbnail_'.$i] != null) {
                $thumbnails[] = $request->file('thumbnail_'.$i)->store('public/uploads/products');
            }
        }

        // 店舗
        if ($request['saleshop-flag'] == 1) {
            $shops = DB::table('shops')->whereIn('id', $request->shops_id)->get();
        } else {
            $shops = [];
        }

        $inputs = $request->all();

        return view('manage.product.item.confirm', [
            'inputs' => $inputs,
            'thumbnails' => $thumbnails,
            'shops' => $shops,
        ]);
    }
}
