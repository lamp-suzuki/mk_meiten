<?php

namespace App\Http\Controllers\Manage\Setting\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function index()
    {
        $manages = Auth::guard('manage')->user();
        $transactions = DB::table('transactions')->where('manages_id', $manages->id)->first();
        return view('manage.setting.transaction.edit', [
            'transactions' => $transactions
        ]);
    }

    public function update($account, Request $request)
    {
        $manages = Auth::guard('manage')->user();
        try {
            DB::table('transactions')->updateOrInsert(
                ['manages_id' => $manages->id],
                [
                    'name' => $request->name,
                    'zipcode' => $request->zipcode,
                    'pref' => $request->pref,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'tel' => $request->tel,
                    'business' => $request->business,
                    'selling_price' => $request->selling_price,
                    'payment_method' => $request->payment_method,
                    'delivery_time' => $request->delivery_time,
                    'returns' => $request->returns,
                    'updated_at' => now(),
                ]
            );
            session()->flash('message', '更新されました。');
        } catch (\Throwable $th) {
            dd($th);
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('manage.setting.transaction.index', ['account' => $account]);
    }
}
