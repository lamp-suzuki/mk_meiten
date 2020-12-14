<?php

namespace App\Http\Controllers\Manage\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    public function index($account, Request $request)
    {
        try {
            DB::table('shops')->where('id', $request['shops_id'])->delete();
            session()->flash('message', '店舗が削除されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('manage.shop.index', ['account' => $account]);
    }
}
