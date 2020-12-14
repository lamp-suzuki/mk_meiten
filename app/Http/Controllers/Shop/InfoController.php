<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // お知らせ詳細
    public function index($account, $id)
    {
        $news = DB::table('posts')->find($id);
        return view('shop.newsdetail', [
            'news' => $news,
        ]);
    }

    // 店舗一覧
    public function shop_list($account)
    {
        $manages = DB::table('manages')->where('domain', $account)->first();
        $shops = DB::table('shops')->where('manages_id', $manages->id)->get();
        return view('shop.shoplist', [
            'manages' => $manages,
            'shops' => $shops,
        ]);
    }

    // 店舗詳細
    public function shopinfo($account, $id)
    {
        $shops = DB::table('shops')->find($id);
        $manages = DB::table('manages')->where('domain', $account)->first();
        return view('shop.shopinfo', [
            'manages' => $manages,
            'shops' => $shops,
        ]);
    }

    // ご利用ガイド
    public function guide()
    {
        $url = $_SERVER['HTTP_HOST'];
        $domain_array = explode('.', $url);
        $sub_domain = $domain_array[0];
        $manages = DB::table('manages')->where('domain', $sub_domain)->first();
        $guide = DB::table('guides')->where('manages_id', $manages->id)->first();
        return view('shop.guide', [
            'guide' => $guide
        ]);
    }
}
