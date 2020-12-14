<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account)
    {
        $sub_domain = $account;
        $manages = DB::table('manages')->where('domain', $sub_domain)->first();
        $news = DB::table('posts')->where('manages_id', $manages->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('shop.news', [
            'news' => $news,
        ]);
    }
}
