<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    // 表示中カレンダーの在庫取得
    public function get_stock($account, Request $request)
    {
        // 表示した月のカレンダーの始まりの日を終わりの日をそれぞれ取得
        $start = $this->formatDate($request['start']);
        $end = $this->formatDate($request['end']);
        $products_id = $request['id'];
        $product = DB::table('products')->find($products_id);
        $default_stock = $product->stock;
        $stock = DB::table('stocks')
        ->select('stock', 'date')
        ->where('products_id', $products_id)
        ->whereBetween('date', [$start, $end])
        ->orderBy('date', 'asc')
        ->get()
        ->groupBy('date');

        $stocks = [];
        for ($i = $start; $i <= $end; $i = date('Y-m-d', strtotime($i.'+1 day'))) {
            $customer_stock = DB::table('stock_customers')
            ->where(['date' => $i, 'products_id' => $products_id])
            ->sum('stock');

            $result_stock = 0;
            if (isset($stock[$i])) {
                // $result_stock = ($stock[$i][0]->stock - $customer_stock) <= 0 ? 0 : ($stock[$i][0]->stock - $customer_stock);
                $stocks[] = [
                  'title' => $stock[$i][0]->stock.'('.$customer_stock.')',
                  'start' => $i
                ];
            } else {
                // $result_stock = ($default_stock - $customer_stock) <= 0 ? 0 : ($default_stock - $customer_stock);
                $stocks[] = [
                  'title' => $default_stock.'('.$customer_stock.')',
                  'start' => $i
                ];
            }
        }
        echo json_encode($stocks);
    }

    // 在庫編集追加
    public function set_stock($account, Request $request)
    {
        $manage = Auth::guard('manage')->user();
        $shops = DB::table('shops')->where('manages_id', $manage->id)->first();
        DB::table('stocks')
        ->updateOrInsert(
            ['products_id' => $request['id'], 'date' => $request['date']],
            [
                'stock' => (int)$request['stock'],
                'shops_id' => $shops->id,
                'manages_id' => $manage->id,
            ]
        );
    }

    // js date format
    public function formatDate($date)
    {
        return str_replace('T00:00:00+09:00', '', $date);
    }
}
