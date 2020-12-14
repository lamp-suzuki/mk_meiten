<?php

namespace App\Http\Controllers\Manage\Product;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index($account)
    {
        // カテゴリ取得
        try {
            $manage = Auth::guard('manage')->user();
            $categories = DB::table('categories')->where([
                ['manages_id', $manage->id],
            ])->orderBy('sort_id', 'asc')->get();
        } catch (\Exception $e) {
        }

        // 商品取得
        $menus = [];
        foreach ($categories as $key => $cat) {
            if (DB::table('products')->where('categories_id', $cat->id)->exists()) {
                $menus[$cat->id] = $menu = DB::table('products')->where('categories_id', $cat->id)->orderBy('sort_id', 'asc')->get();
            }
        }

        return view('manage.product.index', [
            'categories' => $categories,
            'menus' => $menus
        ]);
    }

    // 並び替え
    public function sort_products($account, Request $request)
    {
        $sorted = $request['sort_ids'];
        try {
            foreach ($sorted as $index => $id) {
                DB::table('products')
                ->where('id', $id)
                ->update([
                    'sort_id' => $index
                ]);
            }
            return "OK";
        } catch (\Throwable $th) {
            return "NO";
        }
    }
}
