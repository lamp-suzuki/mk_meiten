<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveController extends Controller
{
    public function index(Request $request)
    {
        $manage = Auth::guard('manage')->user();
        if ($request->has('thumbnail')) {
            $thumbnail = str_replace('public', 'storage', $request['thumbnail']);
        }

        if ($request->has('action') && $request->has('posts_id')) { // 更新
            try {
                DB::table('posts')->where('id', $request['posts_id'])->update([
                    'title' => $request['title'],
                    'content' => $request['content'],
                    'status' => 'public',
                    'created_at' => date('Y-m-d 00:00:00', strtotime($request['created_at'])),
                    'updated_at' => now()
                ]);
                if (isset($thumbnail)) {
                    DB::table('posts')->where('id', $request['posts_id'])->update([
                        'thumbnail' => $thumbnail
                    ]);
                }
                session()->flash('message', 'お知らせが更新されました。');
            } catch (\Throwable $th) {
                session()->flash('error', 'エラーが発生しました。');
            }
        } else { // 新規追加
            try {
                DB::table('posts')->insert([
                    'manages_id' => $manage->id,
                    'title' => $request['title'],
                    'content' => $request['content'],
                    'status' => 'public',
                    'thumbnail' => isset($thumbnail) ? $thumbnail : null,
                    'created_at' => date('Y-m-d 00:00:00', strtotime($request['created_at'])),
                    'updated_at' => now()
                ]);
                session()->flash('message', 'お知らせが公開されました。');
            } catch (\Throwable $th) {
                session()->flash('error', 'エラーが発生しました。');
            }
        }
        // 二重送信対策
        $request->session()->regenerateToken();

        return view('manage.post.save', [
            'title' => $request['title'],
            'thumbnail' => isset($request['thumbnail']) ? $thumbnail : null,
        ]);
    }
}
