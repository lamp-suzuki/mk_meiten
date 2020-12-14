<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    public function index($account, Request $request)
    {
        try {
            DB::table('stock_customers')->where('products_id', $request['menu_id'])->delete();
            DB::table('stocks')->where('products_id', $request['menu_id'])->delete();
            DB::table('products')->where('id', $request['menu_id'])->delete();
            session()->flash('message', '商品が削除されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('manage.product.index', ['account' => $account]);
    }
}
