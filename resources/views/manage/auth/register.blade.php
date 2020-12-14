@extends('layouts.app')
@section('content')
<div class="container">
  <form method="POST" action="{{ route('manage.register', ['account' => $sub_domain]) }}">
    @csrf
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">店舗追加</div>
          <div class="card-body">
            <div class="form-group border-0 row">
              <label for="name" class="col-md-4 col-form-label text-md-right">店舗名</label>
              <div class="col-md-6">
                <input id="name" type="text" class="border form-control @error('name') is-invalid @enderror" name="name"
                  value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group border-0 row">
              <label for="name" class="col-md-4 col-form-label text-md-right">ドメイン名</label>
              <div class="col-md-6">
                <input id="domain" type="text" class="border form-control @error('domain') is-invalid @enderror"
                  name="domain" value="{{ old('domain') }}" required autocomplete="domain" autofocus>
                @error('domain')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group border-0 row">
              <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
              <div class="col-md-6">
                <input id="email" type="email" class="border form-control @error('email') is-invalid @enderror"
                  name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group border-0 row">
              <label for="tel" class="col-md-4 col-form-label text-md-right">電話番号</label>
              <div class="col-md-6">
                <input id="tel" type="tel" class="border form-control @error('tel') is-invalid @enderror"
                  name="tel" value="{{ old('tel') }}" autocomplete="tel">
                @error('tel')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group border-0 row">
              <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
              <div class="col-md-6">
                <input id="password" type="password" class="border form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group border-0 row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード（確認）</label>
              <div class="col-md-6">
                <input id="password-confirm" type="password" class="border form-control" name="password_confirmation"
                  required autocomplete="new-password">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group mb-0 border-0 mt-4">
      <div class="text-center">
        <button type="submit" class="btn btn-primary px-5">登録する</button>
      </div>
    </div>
  </form>
</div>
@endsection