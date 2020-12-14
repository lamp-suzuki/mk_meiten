<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $manage = Auth::guard('manage')->user();
        $posts = DB::table('posts')->where('manages_id', $manage->id)->get();
        return view('manage.post.index', [
            'posts' => $posts
        ]);
    }
}
