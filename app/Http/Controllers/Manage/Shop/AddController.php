<?php

namespace App\Http\Controllers\Manage\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddController extends Controller
{
    public function index()
    {
        return view('manage.shop.add');
    }
}
