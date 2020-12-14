<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:manage');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $manage = Auth::guard('manage')->user();
        $orders = DB::table('orders')->where('manages_id', $manage->id)->orderByDesc('created_at')->limit(5)->get();

        $today_earnings = DB::table('orders')
            ->where(['manages_id' => $manage->id, 'cancel' => 0])
            ->whereDate('created_at', date('Y-m-d'))
            ->sum('total_amount');

        $last_earnings = DB::table('orders')
            ->where(['manages_id' => $manage->id, 'cancel' => 0])
            ->whereDate('created_at', date('Y-m-d', strtotime('-1 days')))
            ->sum('total_amount');

        $comparison = round(($today_earnings / ($last_earnings != 0 ? $last_earnings : 1) * 100) - 100, 2);

        return view('manage.home', [
            'orders' => $orders,
            'today_earnings' => $today_earnings,
            'comparison' => $comparison,
        ]);
    }
}
