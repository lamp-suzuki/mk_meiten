<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfirmController extends Controller
{
    public function index(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'created_at' => 'required',
        ])->validate();

        // 画像ファイル処理
        $thumbnail = null;
        if ($request['thumbnail'] != null) {
            $thumbnail = $request->file('thumbnail')->store('public/uploads/posts');
        }
        $inputs = $request->all();

        return view('manage.post.confirm', [
          'inputs' => $inputs,
          'thumbnail' => $thumbnail
        ]);
    }
}
