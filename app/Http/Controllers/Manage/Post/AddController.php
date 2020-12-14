<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class AddController extends Controller
{
    public function index()
    {
        return view('manage.post.add');
    }
}
