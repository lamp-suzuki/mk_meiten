<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // 特定商取引法表示
    public function law()
    {
        $url = $_SERVER['HTTP_HOST'];
        $domain_array = explode('.', $url);
        $sub_domain = $domain_array[0];
        $manages = DB::table('manages')->where('domain', $sub_domain)->first();
        $transactions = DB::table('transactions')->where('manages_id', $manages->id)->first();
        return view('shop.law', [
            'transactions' => $transactions,
        ]);
    }

    // 特定商取引法表示
    public function privacy()
    {
        return view('shop.privacy');
    }
}
