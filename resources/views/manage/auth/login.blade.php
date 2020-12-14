<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="robots" content="noindex" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ログイン | TakeEats</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Noto+Sans+JP:wght@400;700&display=swap" />
  <link href="{{ asset('css/manage/app.css') }}" rel="stylesheet">
  <style>
    html,
    body {
      height: 100%;
    }

    body {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-align: center;
      align-items: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
    }

    .form-signin {
      width: 100%;
      max-width: 330px;
      padding: 15px;
      margin: auto;
    }

    .form-signin .checkbox {
      font-weight: 400;
    }

    .form-signin .form-control {
      position: relative;
      box-sizing: border-box;
      height: auto;
      padding: 10px;
      font-size: 16px;
    }

    .form-signin .form-control:focus {
      z-index: 2;
    }

    .form-signin input[type="text"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
  </style>
</head>

<body class="text-center">
  <form class="form-signin" method="POST" action="{{ route('manage.login', ['account' => $sub_domain]) }}">
    @csrf
    <img src="{{ asset('images/logo_square.png') }}" alt="TakeEats"
      srcset="{{ asset('images/logo_square.png') }} 1x, {{ asset('images/logo_square@2x.png') }} 2x" />
    <h1 class="h5 mt-2 mb-5 font-weight-normal">ログイン</h1>
    @if ($errors->any())
    <p class="mb-3" role="alert"><strong class="text-danger">正しいログイン情報を入力ください</strong></p>
    @endif
    <label for="inputEmail" class="sr-only">アカウント名</label>
    <input type="email" id="inputEmail" class="form-control" name="email" value="{{ old('email') }}"
      placeholder="メールアドレス" required autofocus />
    <label for="inputPassword" class="sr-only">パスワード</label>
    <input type="password" id="inputPassword" class="form-control" name="password" placeholder="パスワード" required />
    <button class="btn btn-success btn-block text-white py-2" type="submit">ログイン</button>
    {{-- <div class="form-check bg-transparent">
      <input class="form-check-input" type="checkbox" name="remember" id="remember"
        {{ old('remember') ? 'checked' : '' }}>
    <label class="form-check-label" for="remember">ログイン状態を記憶する</label>
    </div> --}}
    <p class="mt-5 mb-3 text-muted">&copy; 2020 TakeEats</p>
  </form>
</body>

</html>