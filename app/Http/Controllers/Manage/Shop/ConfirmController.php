<?php

namespace App\Http\Controllers\Manage\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConfirmController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        Validator::make($request->all(), [
            'name' => 'required',
            'tel' => 'required',
            'email' => 'required|email',
            'zipcode' => 'required',
            'pref' => 'required',
            'address1' => 'required',
            'address2' => 'required',
        ])->validate();

        $inputs = $request->all();
        // dd($inputs);

        return view('manage.shop.confirm', ['inputs' => $inputs]);
    }
}
