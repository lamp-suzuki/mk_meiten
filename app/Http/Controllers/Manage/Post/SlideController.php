<?php

namespace App\Http\Controllers\Manage\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SlideController extends Controller
{
    public function index()
    {
        $manages = Auth::guard('manage')->user();
        $slides = DB::table('slides')->where('manages_id', $manages->id)->first();
        return view('manage.post.slide', [
            'slides' => $slides,
        ]);
    }

    public function update($account, Request $request)
    {
        $manages = Auth::guard('manage')->user();

        try {
            for ($i=1; $i <= 5; $i++) {
                $slide = null;
                if ($request['slide_'.$i] != null) {
                    $slide = $request->file('slide_'.$i)->store('public/uploads/slides');
                    $slide = str_replace('public', 'storage', $slide);
                } else {
                    if ($request->has('slide_'.$i.'_flag') && $request['slide_'.$i] == null) {
                        continue;
                    }
                }
                DB::table('slides')->updateOrInsert(
                    ['manages_id' => $manages->id],
                    ['manages_id' => $manages->id, 'slide_'.$i => $slide, 'created_at' => now(), 'updated_at' => now()]
                );
            }
            session()->flash('message', 'スライドショーが更新されました。');
        } catch (\Throwable $th) {
            session()->flash('error', 'エラーが発生しました。');
        }

        // 二重送信対策
        $request->session()->regenerateToken();
        return redirect()->route('manage.post.slide', ['account' => $account]);
    }
}
