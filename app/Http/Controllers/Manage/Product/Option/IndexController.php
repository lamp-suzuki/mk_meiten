<?php

namespace App\Http\Controllers\Manage\Product\Option;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index($account)
    {
        try {
            $manage = Auth::guard('manage')->user();
            $categories = DB::table('categories')->where([
                ['manages_id', $manage->id],
            ])->orderBy('sort_id', 'asc')->get();
            $categories_ids = [];
            foreach ($categories as $cat) {
                $categories_ids[] = $cat->id;
            }
            $options = [];
            foreach ($categories_ids as $id) {
                $options[$id] = DB::table('options')->where('categories_id', $id)->get();
            }
        } catch (\Exception $e) {
        }
        // dd($options);
        return view('manage.product.option.index', [
            'categories' => $categories,
            'options' => $options,
        ]);
    }

    // 追加
    public function add($account, Request $request)
    {
        try {
            DB::table('options')->insert([
                'categories_id' => $request['category_id'],
                'name' => $request['option_name'],
                'price' => $request['option_price'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
            session()->flash('message', 'オプションが追加されました。');
        } catch (\Exception $e) {
            session()->flash('error', 'エラーが発生しました。');
        }

        return redirect()->route('manage.product.option.index', ['account' => $account]);
    }

    // 編集
    public function edit($account, Request $request)
    {
        try {
            DB::table('options')
                ->where('id', $request['option_id'])
                ->update([
                    'name' => $request['option_name'],
                    'price' => $request['option_price'],
                    'updated_at' => now(),
                ]);
            session()->flash('message', 'オプションが編集されました。');
        } catch (\Exception $e) {
            session()->flash('error', 'エラーが発生しました。');
        }

        return redirect()->route('manage.product.option.index', ['account' => $account]);
    }

    // 削除
    public function delete($account, Request $request)
    {
        try {
            DB::table('options')->where('id', $request['option_id'])->delete();
            session()->flash('message', 'オプションが削除されました。');
        } catch (\Exception $e) {
            session()->flash('error', 'エラーが発生しました。');
        }

        return redirect()->route('manage.product.option.index', ['account' => $account]);
    }
}
