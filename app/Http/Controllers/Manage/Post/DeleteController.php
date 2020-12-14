<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function index($account, Request $request)
    {
        try {
            DB::table('posts')->where('id', $request['posts_id'])->delete();
            session()->flash('message', 'お知らせが削除されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('manage.post.index', ['account' => $account]);
    }
}
