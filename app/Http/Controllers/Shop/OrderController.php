<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $request->session()->put('form_cart', $request->all());

        if ($request['okimochi'] != 0) {
            $old_amount = session('cart.amount');
            session()->put('cart.amount', $old_amount+(int)$request['okimochi']);
        }

        if ($request->has('email') && $request->has('password')) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $users = Auth::guard('web')->user();
                return view('shop.order', [
                    'users' => $users,
                ]);
            }
        } else {
            return view('shop.order');
        }
    }
}
