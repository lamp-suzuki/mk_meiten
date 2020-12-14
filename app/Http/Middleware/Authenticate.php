<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $url = $_SERVER['HTTP_HOST'];
        $domain_array = explode('.', $url);
        $sub_domain = $domain_array[0];

        if (! $request->expectsJson()) {
            if ($request->is('manage/*')) {
                return route('manage.login', ['account' => $sub_domain]);
            } else {
                return route('login', ['account' => $sub_domain]);
            }
        }
    }
}
