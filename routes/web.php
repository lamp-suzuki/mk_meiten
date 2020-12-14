<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain('{account}.'.config('app.domain'))->group(function ($account) {
    // 店舗会員
    Auth::routes();
    Route::namespace('Auth')->middleware('auth')->group(function () {
        Route::get('/member', 'MemberController@index')->name('member.index');
        Route::get('/member/edit', 'MemberController@edit')->name('member.edit');
        Route::post('/member/update', 'MemberController@update')->name('member.update');
        Route::get('/member/orders', 'MemberController@orders')->name('member.orders');
        Route::post('/member/again', 'MemberController@again_order')->name('member.again');
    });

    // 店舗サイト
    Route::namespace('Shop')->name('shop.')->middleware('stop.flag')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');

        // STEP(ajax)
        Route::post('/set-service', 'HomeController@set_service')->name('set.service');
        Route::post('/get-business-time', 'HomeController@get_business_time')->name('get.business.time');
        Route::post('/set-select-time', 'HomeController@set_select_time')->name('set.select.time');
        Route::post('/set-select-shop', 'HomeController@set_select_shop')->name('set.select.shop');
        Route::post('/get-service', 'HomeController@get_service')->name('get.service');
        Route::post('/reset-session', 'HomeController@reset_session')->name('reset.session');

        // お受け取り方法
        Route::post('/change-receipt', 'HomeController@change_receipt')->name('change.receipt');

        // カート追加
        Route::post('/addcart', 'HomeController@addcart')->name('addcart');

        // カートページ
        Route::get('/cart', 'CartController@index')->name('cart');
        Route::post('/cart-delete', 'CartController@delete')->name('cart.delete');
        Route::post('/change-quantity', 'CartController@change_quantity')->name('change.quantity');
        Route::get('/cart-vali', 'CartController@cart_vali')->name('vali');

        // 注文
        Route::any('/order', 'OrderController@index')->name('order');
        Route::any('/payment', 'PaymentController@index')->name('payment');
        Route::any('/confirm', 'ConfirmController@index')->name('confirm');
        Route::post('/thanks', 'ThanksController@index')->name('thanks');

        // お知らせ
        Route::get('/news', 'NewsController@index')->name('news');
        Route::get('/info/{id}', 'InfoController@index')->name('info');

        // 店舗情報
        Route::get('/shopinfo/{id}', 'InfoController@shopinfo')->name('shopinfo');
        Route::get('/shop-list', 'InfoController@shop_list')->name('shoplist');

        Route::get('/guide', 'InfoController@guide')->name('guide'); // ご利用ガイド
        Route::get('/law', 'TransactionController@law')->name('law'); // 特定商取引法表示
        Route::get('/privacy', 'TransactionController@privacy')->name('privacy'); // privacy
    });

    // 管理画面
    Route::prefix('manage')->namespace('Manage')->name('manage.')->group(function () {
        Auth::routes(); // ログイン・ログアウト

        Route::middleware(['auth:manage'])->group(function () {
            // ダッシュボード
            Route::get('/home', 'HomeController@index')->name('home');

            // 受注管理
            Route::prefix('order')->namespace('Order')->name('order.')->group(function () {
                Route::any('/', 'IndexController@index')->name('index'); // 一覧
                Route::get('/detail/{id}', 'DetailController@index')->name('detail'); // 詳細
                Route::post('/detail/{id}/cancel', 'DetailController@cancel')->name('cancel'); // 詳細

                Route::post('/download', 'IndexController@download')->name('download'); // ダウンロード
            });

            // 商品管理
            Route::prefix('product')->namespace('Product')->name('product.')->group(function () {
                Route::get('/', 'IndexController@index')->name('index');
                Route::post('/sort', 'IndexController@sort_products')->name('sort'); // 並び替え
                // メニュー
                Route::prefix('item')->namespace('Item')->name('item.')->group(function () {
                    Route::get('/add', 'AddController@index')->name('add'); // 新規追加
                    Route::post('/confirm', 'ConfirmController@index')->name('confirm'); // 確認
                    Route::post('/save', 'SaveController@index')->name('save'); // 公開
                    Route::get('/edit/{id}', 'EditController@index')->name('edit'); // 編集
                    Route::post('/delete', 'DeleteController@index')->name('delete'); // 削除

                    // 在庫系
                    Route::get('/get-stock', 'StockController@get_stock')->name('get.stock');
                    Route::post('/set-stock', 'StockController@set_stock')->name('set.stock');
                });
                // カテゴリー
                Route::prefix('category')->namespace('Category')->name('category.')->group(function () {
                    Route::get('/', 'IndexController@index')->name('index');
                    Route::post('/add', 'IndexController@add')->name('add');
                    Route::post('/edit', 'IndexController@edit')->name('edit');
                    Route::post('/delete', 'IndexController@delete')->name('delete');
                    Route::post('/sort', 'IndexController@sort_cat')->name('sort'); // 並び替え
                });
                // オプション
                Route::prefix('option')->namespace('Option')->name('option.')->group(function () {
                    Route::get('/', 'IndexController@index')->name('index');
                    Route::post('/add', 'IndexController@add')->name('add');
                    Route::post('/edit', 'IndexController@edit')->name('edit');
                    Route::post('/delete', 'IndexController@delete')->name('delete');
                });
            });

            // お知らせ
            Route::prefix('post')->namespace('Post')->name('post.')->group(function () {
                Route::get('/', 'IndexController@index')->name('index'); // 一覧
                Route::get('/add', 'AddController@index')->name('add'); // 新規追加
                Route::post('/confirm', 'ConfirmController@index')->name('confirm'); // 確認
                Route::post('/save', 'SaveController@index')->name('save'); // 公開
                Route::post('/edit', 'EditController@index')->name('edit'); // 編集
                Route::post('/delete', 'DeleteController@index')->name('delete'); // 削除

                // スライドショー
                Route::get('/slide', 'SlideController@index')->name('slide');
                Route::post('/slide/update', 'SlideController@update')->name('slide.update');

                // ご利用ガイド
                Route::get('/guide', 'GuideController@index')->name('guide');
                Route::post('/guide/update', 'GuideController@update')->name('guide.update');
            });

            // 分析
            Route::prefix('data')->namespace('Data')->name('data.')->group(function () {
                Route::get('/order', 'DataController@order')->name('order');
                Route::get('/member', 'DataController@member')->name('member');
            });

            // 店舗管理
            Route::prefix('shop')->namespace('Shop')->name('shop.')->group(function () {
                Route::get('/', 'IndexController@index')->name('index');
                Route::get('/add', 'AddController@index')->name('add');
                Route::post('/confirm', 'ConfirmController@index')->name('confirm');
                Route::post('/save', 'SaveController@index')->name('save');
                Route::post('/edit', 'EditController@index')->name('edit');
                Route::post('/delete', 'DeleteController@index')->name('delete');
            });

            // 設定
            Route::prefix('setting')->namespace('Setting')->name('setting.')->group(function () {
                Route::get('/', 'BasicController@index')->name('basic');
                Route::post('/update', 'BasicController@update')->name('update');

                // サービス設定
                Route::prefix('service')->name('service.')->group(function () {
                Route::get('/', 'ServiceController@index')->name('index');
                Route::post('/takeout/update', 'ServiceController@takeout_update')->name('takeout.update');
                Route::post('/delivery/update', 'ServiceController@delivery_update')->name('delivery.update');
                Route::post('/ec/update', 'ServiceController@ec_update')->name('ec.update');
            });

                // その他設定
                Route::prefix('transaction')->namespace('Transaction')->name('transaction.')->group(function () {
                    Route::get('/', 'EditController@index')->name('index');
                    Route::post('/update', 'EditController@update')->name('update');
                });
            });

            Route::view('/manual', 'manage.manual')->name('manual'); // マニュアル
            Route::view('/consultation', 'manage.consultation')->name('consultation'); // 相談会
        });
    });
});
