<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddController extends Controller
{
    public function index($account, Request $request)
    {
        if (isset($request['cat_id'])) {
            $category_id = (int)$request['cat_id'];
            $request->session()->put('cat_id', $category_id);
        } else {
            $category_id = $request->session()->get('cat_id');
        }

        $manage = Auth::guard('manage')->user();

        $category = DB::table('categories')->where('id', $category_id)->first();
        $options = DB::table('options')->where('categories_id', $category_id)->get();
        $shops = DB::table('shops')->where('manages_id', $manage->id)->get();

        return view('manage.product.item.add', [
            'category' => $category,
            'shops' => $shops,
            'options' => $options,
        ]);
    }
}
