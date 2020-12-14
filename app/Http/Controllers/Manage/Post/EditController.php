<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
{
    public function index(Request $request)
    {
        $post = DB::table('posts')->where('id', $request['posts_id'])->first();
        return view('manage.post.edit', [
            'post' => $post
        ]);
    }
}
