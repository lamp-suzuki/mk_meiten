<?php

namespace App\Http\Controllers\Manage\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function order($account)
    {
        $manage = DB::table('manages')->where('domain', $account)->first();
        $orders = DB::table('orders')
        ->select(DB::raw("sum(total_amount) as total"), DB::raw("date(created_at) as dates"))
        ->where('manages_id', $manage->id)
        ->whereYear('created_at', date('Y'))
        ->whereMonth('created_at', date('m'))
        ->groupBy('dates')
        ->orderBy('dates', 'asc')
        ->get();

        $stock_customers = DB::table('stock_customers')
        ->select('products_id', DB::raw("COUNT(products_id) as counts"))
        ->where('manages_id', $manage->id)
        ->limit(10)
        ->groupBy('products_id')
        ->orderBy('counts', 'desc')
        ->get()->toArray();

        $rankings = []; // 購入商品ランキング
        foreach ($stock_customers as $key => $stock_customer) {
            $product = DB::table('products')->find($stock_customer->products_id);
            $rankings[] = [
                'name' => $product->name,
                'thumbnail' => $product->thumbnail_1,
                'price' => $product->price,
                'counts' => $stock_customer->counts,
            ];
        }

        $labels = [];
        $data = [];
        foreach ($orders as $key => $order) {
            $labels[] = $order->dates;
            $data[] = (int)$order->total;
        }

        return view('manage.data.order', [
            'labels' => $labels,
            'data' => $data,
            'rankings' => $rankings,
        ]);
    }

    public function member()
    {
        return view('manage.data.member');
    }
}
