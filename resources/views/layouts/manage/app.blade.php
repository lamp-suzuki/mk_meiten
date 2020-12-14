<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>管理画面 | TakeEats</title>
  <!-- Scripts -->
  <script src="{{ asset('js/manage/app.js') }}" defer></script>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <!-- Styles -->
  <link href="{{ asset('css/manage/app.css') }}" rel="stylesheet">
</head>

<body>
  <nav id="navbar" class="navbar bg-primary flex-lg-nowrap p-0">
    <a class="navbar-brand col-lg-2 col-6 mr-lg-3 mr-0 px-3" href="{{ route('manage.home', ['account' => $sub_domain]) }}">
      <img src="{{ asset('images/logo.png') }}" alt="TakeEats"
        srcset="{{ asset('images/logo.png') }} 1x, {{ asset('images/logo@2x.png') }} 2x" />
    </a>
    <span class="mr-auto text-white d-lg-block d-none">こんにちは、{{ Auth::user()->name }}</span>
    <a class="btn btn-light rounded-pill mr-5 px-4 d-lg-block d-none" href="{{ url('/') }}" target="_blank">
      <span class="d-inline-block align-middle">サイトを確認する</span>
      <i class="d-inline-block align-middle" data-feather="external-link"></i>
    </a>
  </nav>
  <div class="navbar-toggle-btn">
    <i data-feather="menu"></i>
  </div>
  <!-- .navbar -->
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-lg-2 d-lg-block px-0 bg-white sidebar">
        <div class="pt-lg-5">
          <div class="head">
            <p>
              こんにちは、
              <span class="d-block">{{ Auth::user()->name }}</span>
            </p>
            <form action="{{ route('manage.logout', ['account' => $sub_domain]) }}" method="post">
              @csrf
              <button class="btn btn-link text-body font-weight-normal p-0 border-0">ログアウト</button>
            </form>
          </div>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('manage.home', ['account' => $sub_domain]) }}">
                <span class="feather-icon"><i data-feather="home"></i></span>
                <span>トップ</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('manage.order.index', ['account' => $sub_domain]) }}">
                <span class="feather-icon"><i data-feather="clipboard"></i></span>
                <span>注文管理</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('manage.product.index', ['account' => $sub_domain]) }}">
                <span class="feather-icon"><i data-feather="book"></i></span>
                <span>商品の追加・編集</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('manage.post.index', ['account' => $sub_domain]) }}">
                <span class="feather-icon"><i data-feather="feather"></i></span>
                <span>お知らせの更新</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('manage.data.order', ['account' => $sub_domain]) }}">
                <span class="feather-icon"><i data-feather="bar-chart"></i></span>
                <span>データ分析をみる</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('manage.shop.index', ['account' => $sub_domain]) }}">
                <span class="feather-icon"><i data-feather="flag"></i></span>
                <span>店舗の追加・編集</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('manage.setting.basic', ['account' => $sub_domain]) }}">
                <span class="feather-icon"><i data-feather="settings"></i></span>
                <span>設定</span>
              </a>
            </li>
          </ul>
          <div class="foot">
            <a href="{{ route('manage.setting.transaction.index', ['account' => $sub_domain]) }}">
              <i class="d-inline-block align-middle" data-feather="triangle"></i>
              <span class="d-inline-block align-middle">運営者情報に関する設定</span>
            </a>
            <a href="{{ route('manage.manual', ['account' => $sub_domain]) }}">
              <i class="d-inline-block align-middle" data-feather="triangle"></i>
              <span class="d-inline-block align-middle">ご利用マニュアルのダウンロード</span>
            </a>
            <a href="{{ route('manage.consultation', ['account' => $sub_domain]) }}">
              <i class="d-inline-block align-middle" data-feather="triangle"></i>
              <span class="d-inline-block align-middle">無料ご相談会</span>
            </a>
          </div>
        </div>
      </nav>
      <!-- #sidebarMenu -->
      <main id="main" role="main" class="col-lg-10 ml-sm-auto px-lg-4 bg-light">
        <div class="wrap">
          @yield('content')
        </div>
        <!-- .wrap -->
        <div class="socket">©2020 TakeEats</div>
      </main>
      <!-- #main -->
    </div>
    <!-- .row -->
  </div>
  <!-- .container-fluid -->
  <div class="orverray"></div>
</body>

</html>