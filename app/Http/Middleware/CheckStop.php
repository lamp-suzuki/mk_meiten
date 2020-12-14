<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\DB;

class CheckStop
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sub_domain = explode('.', $_SERVER['HTTP_HOST'])[0];
        $manages = DB::table('manages')->where('domain', $sub_domain)->first();
        if ($manages->show_hide === 0) {
            $request->merge([
                'stop_flag' => true
            ]);
            if ($request->path() === '/') {
                return $next($request);
            } else {
                return redirect()->route('shop.home', ['account' => $sub_domain]);
            }
        } else {
            return $next($request);
        }
    }
}
