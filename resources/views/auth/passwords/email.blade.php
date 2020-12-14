@extends('layouts.shop.app')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>パスワード変更</h2>
  </div>
</section>
<div class="py-5">
  <div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">登録メールアドレス</label>

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

      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary px-5">送信する</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection