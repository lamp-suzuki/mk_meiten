<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AggregateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $orders = DB::table('orders')
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->whereMonth('created_at', date('m', strtotime('-1 month')))
            ->get()->groupBy('manages_id')->toArray();
            return DB::table('manages')->select('id', 'name', 'email', 'tel')->whereIn('id', array_keys($orders))->paginate(50);
        } catch (\Throwable $th) {
            // dd($th);
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
        try {
            $orders = DB::table('orders')
            ->select('id', 'payment_method', 'total_amount', 'created_at')
            ->where('manages_id', $id)
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->whereMonth('created_at', date('m', strtotime('-1 month')))
            ->get();
            return $orders;
        } catch (\Throwable $th) {
            // dd($th);
        }
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
