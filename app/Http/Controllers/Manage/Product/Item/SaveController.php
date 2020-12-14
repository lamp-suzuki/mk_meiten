<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveController extends Controller
{
    public function index($account, Request $request)
    {
        // dd($request);
        if ($request->action === '前のページに戻る') {
            return redirect()->route('manage.product.item.add' , ['account' => $account])->withInput();
        } else {
            $manage = Auth::guard('manage')->user();

            $shops = DB::table('shops')->where('manages_id', $manage->id)->get();
            $shops_ids = '';
            if ($request['shop_id'] !== null) {
                $only_shops = explode(',', $request['shop_id']);
                foreach ($shops as $shop) {
                    if (in_array((String)$shop->id, $only_shops)) {
                        $shops_ids .= $shop->id.',';
                    }
                }
            } else {
                foreach ($shops as $shop) {
                    $shops_ids .= $shop->id.',';
                }
            }

            if ($request->has('thumbnail_1')) {
                $thumbnail_1 = str_replace('public', 'storage', $request['thumbnail_1']);
            }
            if ($request->has('thumbnail_2')) {
                $thumbnail_2 = str_replace('public', 'storage', $request['thumbnail_2']);
            }
            if ($request->has('thumbnail_3')) {
                $thumbnail_3 = str_replace('public', 'storage', $request['thumbnail_3']);
            }

            if ($request->has('update') && $request->has('menus_id')) { // 上書き
                try {
                    DB::table('products')->where('id', $request['menus_id'])
                    ->update([
                        'options_id' => isset($request['options_id']) ? $request['options_id'] : null,
                        'shops_id' => $shops_ids,
                        'name' => $request['name'],
                        'price' => $request['price'],
                        'unit' => $request['unit'],
                        'explanation' => $request['explanation'],
                        'stock' => $request['stock'],
                        'lead_time' => $request['lead_time'],
                        'status' => $request->has('draft') ? 'draft' : 'public',
                        'takeout_flag' => isset($request['takeout_flag']) ? $request['takeout_flag'] : 0,
                        'delivery_flag' => isset($request['delivery_flag']) ? $request['delivery_flag'] : 0,
                        'ec_flag' => isset($request['ec_flag']) ? $request['ec_flag'] : 0,
                        'release_start' => $request['release_start'],
                        'release_end' => $request['release_end'],
                        'updated_at' => now()
                    ]);

                    if (isset($thumbnail_1)) {
                        DB::table('products')->where('id', $request['menus_id'])
                        ->update([
                            'thumbnail_1' => $thumbnail_1,
                        ]);
                    }
                    if (isset($thumbnail_2)) {
                        DB::table('products')->where('id', $request['menus_id'])
                        ->update([
                            'thumbnail_2' => $thumbnail_2,
                        ]);
                    }
                    if (isset($thumbnail_3)) {
                        DB::table('products')->where('id', $request['menus_id'])
                        ->update([
                            'thumbnail_3' => $thumbnail_3,
                        ]);
                    }
                } catch (\Exception $e) {
                    echo $e;
                }
            } else { // 新規追加
                try {
                    DB::table('products')->insert([
                        'manages_id' => $manage->id,
                        'categories_id' => $request['category_id'],
                        'options_id' => isset($request['options_id']) ? $request['options_id'] : null,
                        'shops_id' => $shops_ids,
                        'name' => $request['name'],
                        'price' => $request['price'],
                        'unit' => $request['unit'],
                        'explanation' => $request['explanation'],
                        'stock' => $request['stock'],
                        'lead_time' => $request['lead_time'],
                        'status' => $request->has('draft') ? 'draft' : 'public',
                        'takeout_flag' => isset($request['takeout_flag']) ? $request['takeout_flag'] : 0,
                        'delivery_flag' => isset($request['delivery_flag']) ? $request['delivery_flag'] : 0,
                        'ec_flag' => isset($request['ec_flag']) ? $request['ec_flag'] : 0,
                        'thumbnail_1' => isset($request['thumbnail_1']) ? $thumbnail_1 : null,
                        'thumbnail_2' => isset($request['thumbnail_2']) ? $thumbnail_2 : null,
                        'thumbnail_3' => isset($request['thumbnail_3']) ? $thumbnail_3 : null,
                        'release_start' => $request['release_start'],
                        'release_end' => $request['release_end'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } catch (\Exception $e) {
                    echo $e;
                }
            }
            // 二重送信対策
            $request->session()->regenerateToken();
        }

        return view('manage.product.item.save', [
            'name' => $request['name'],
            'price' => $request['price'],
            'thumbnail' => isset($request['thumbnail_1']) ? $thumbnail_1 : null,
        ]);
    }
}
