const mix = require("laravel-mix");

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel application. By default, we are compiling the Sass
| file for the application as well as bundling up all the JS files.
|
*/

let productionSourceMaps = false;

mix.webpackConfig(webpack => {
  return {
    plugins: [
      new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery",
        "window.jQuery": "jquery"
      })
    ]
  };
});

// 管理画面用
mix
  .js("resources/js/manage/app.js", "public/js/manage")
  .sass("resources/sass/manage/app.scss", "public/css/manage")
  .sourceMaps(productionSourceMaps, "source-map");

// 店舗サイト用
mix
  .js("resources/js/shop/app.js", "public/js/shop")
  .sass("resources/sass/shop/app.scss", "public/css/shop")
  .sourceMaps(productionSourceMaps, "source-map");
