@extends('layouts.shop.app')

@section('page_title', '会員ログイン')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>会員ログイン</h2>
  </div>
</section>

<section class="py-4 mb-5">
  <div class="container">
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

        <div class="col-md-6">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus>
          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
        <div class="col-md-6">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="current-password">
          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row mb-0">
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary px-5">ログインする</button>
          @if (Route::has('password.request'))
          <p class="mt-3 mb-0"><a class="text-body" href="{{ route('password.request') }}">パスワードをお忘れの方はこちら</a></p>
          @endif
        </div>
      </div>
    </form>
  </div>
</section>
@endsection