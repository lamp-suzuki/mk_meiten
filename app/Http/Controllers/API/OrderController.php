<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $orders = DB::table('orders');
            if ($request->has('when')) {
                switch ($request->when) {
                    case 'last_month': // 先月
                        $orders->whereYear('created_at', date('Y', strtotime('-1 months')))->whereMonth('created_at', date('m', strtotime('-1 months')));
                        break;
                    case 'last_day': // 昨日
                        $orders->whereDate('created_at', date('Y-m-d', strtotime('-1 days')));
                        break;
                    case 'today': // 本日
                        $orders->whereDate('created_at', date('Y-m-d'));
                        break;
                    case 'month': // 今月
                        $orders->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
                        break;
                    default: // 今月
                        $orders->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
                        break;
                }
            }

            $total = $orders->sum('total_amount');

            $sum = \App\Order::whereYear('created_at', date('Y'))
                ->get()
                ->groupBy(function ($row) {
                    return $row->created_at->format('m');
                })
                ->map(function ($day) {
                    return $day->sum('total_amount');
                });

            return ['sum' => $sum, 'total' => $total];

        } catch (\Throwable $th) {
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
