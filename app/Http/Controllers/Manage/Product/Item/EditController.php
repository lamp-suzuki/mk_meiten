<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function index($account, $id)
    {
        $manage = Auth::guard('manage')->user();
        $menu = DB::table('products')->find($id);
        $category = DB::table('categories')->find($menu->categories_id);
        $options = DB::table('options')->where('categories_id', $category->id)->get();
        $shops = DB::table('shops')->where('manages_id', $manage->id)->get();
        $only_shops = explode(',', $menu->shops_id);
        array_pop($only_shops);

        $shops_flag = count($shops) == count($only_shops) ? false : true;

        return view('manage.product.item.edit', [
            'menu' => $menu,
            'category' => $category,
            'options' => $options,
            'shops' => $shops,
            'only_shops' => $only_shops,
            'shops_flag' => $shops_flag,
        ]);
    }

    public function save($account, Request $request)
    {
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
        $inputs = $request->all();

        return view('manage.product.item.confirm', [
            'inputs' => $inputs,
            'thumbnails' => $thumbnails
        ]);
    }
}
