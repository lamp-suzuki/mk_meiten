<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != null) {
            $url = $_SERVER['HTTP_HOST'];
            $domain_array = explode('.', $url);
            $sub_domain = $domain_array[0];
            $manages = DB::table('manages')->where('domain', $sub_domain)->first();

            if ($manages !== null) {
                $manages_shops = DB::table('shops')->where('manages_id', $manages->id)->first();
                $title = $manages->name;
                $description = $manages->description;
                View::share([
                    'sub_domain' => $sub_domain,
                    'meta_title' => $title,
                    'meta_description' => $description,
                    'manages' => $manages,
                    'manages_shops' => $manages_shops,
                ]);
            } else {
                abort('404');
            }
        }
    }
}
