<?php

namespace App\Http\Controllers\Manage\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
{
    public function index(Request $request)
    {
        $shops_id = $request['shops_id'];
        $shop = DB::table('shops')->where('id', $shops_id)->first();
        return view('manage.shop.edit', [
            'shop' => $shop,
            'shops_id' => $shops_id,
        ]);
    }
}
