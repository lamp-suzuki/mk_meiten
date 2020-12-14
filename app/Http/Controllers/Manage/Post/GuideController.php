<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuideController extends Controller
{
    public function index()
    {
        $manages = Auth::guard('manage')->user();
        $contents = DB::table('guides')->where('manages_id', $manages->id)->first();

        return view('manage.post.guide', [
          'contents' => $contents
        ]);
    }

    public function update($account, Request $request)
    {
        $manages = Auth::guard('manage')->user();
        try {
            DB::table('guides')->updateOrInsert(
                ['manages_id' => $manages->id],
                [
                    'contents' => $request->guide_content,
                    'updated_at' => now()
                ]
            );
            session()->flash('message', '更新されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。');
        }

        // 二重送信対策
        $request->session()->regenerateToken();
        return redirect()->route('manage.post.guide', ['account' => $account]);
    }
}
