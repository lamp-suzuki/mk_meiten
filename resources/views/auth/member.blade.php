@extends('layouts.shop.app')

@section('page_title', '会員情報の確認・編集')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>会員情報の確認・編集</h2>
  </div>
</section>
<div class="pt-5">
  <div class="container">

    {{-- 成功メッセージ --}}
    @if(session()->has('message'))
    <div class="alert alert-info alert-dismissible fade show mt-3">
      {{ session('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    {{-- エラーメッセージ --}}
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3">
      {{ session('error') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    <div class="member-info">
      <img src="{{ asset('/images/icon_user.png') }}" alt="user icon"
        srcset="{{ asset('/images/icon_user.png') }} 1x, {{ asset('/images/icon_user@2x.png') }} 2x" />
      <div class="form-group border-bottom pb-3 mt-5">
        <label class="small d-block mb-1">氏名</label>
        <p class="mb-0">{{ Auth::user()->name }}</p>
      </div>
      <div class="form-group border-bottom pb-3">
        <label class="small d-block mb-1">フリガナ</label>
        <p class="mb-0">{{ Auth::user()->furigana }}</p>
      </div>
      <div class="form-group border-bottom pb-3">
        <label class="small d-block mb-1">電話番号</label>
        <p class="mb-0">{{ Auth::user()->tel }}</p>
      </div>
      <div class="form-group border-bottom pb-3">
        <label class="small d-block mb-1">メールアドレス</label>
        <p class="mb-0">{{ Auth::user()->email }}</p>
      </div>
      {{-- <div class="form-group border-bottom pb-3">
        <label class="small d-block mb-1">性別</label>
        <p class="mb-0">男性</p>
      </div>
      <div class="form-group border-bottom pb-3">
        <label class="small d-block mb-1">生年月日</label>
        <p class="mb-0">1990/01/01</p>
      </div> --}}
      <div class="form-group mb-0">
        <label class="small d-block mb-1">住所</label>
        <p class="mb-0">
          〒{{ Auth::user()->zipcode }}
          <br />
          {{ Auth::user()->address1 }}
          {{ Auth::user()->address2 }}
        </p>
      </div>
    </div>
    <!-- .member-info -->
    <div class="text-center mt-4">
      <a class="btn btn-primary px-5" href="{{ route('member.edit') }}">
        <i data-feather="edit" class="d-inline-block align-middle"></i>
        <span class="d-inline-block align-middle">内容を編集する</span>
      </a>
    </div>
  </div>
</div>
<h3 class="ttl-horizon mt-5 mb-0">
  <span class="d-block container">その他の設定</span>
</h3>
<div class="py-3">
  <div class="container">
    <p class="m-0">
      <a href="{{ route('password.update') }}">
        <i data-feather="lock" class="mr-1"></i>
        <span class="text-body">ログインパスワードを変更する</span>
      </a>
    </p>
  </div>
</div>
<div class="border-top border-bottom py-3">
  <div class="container">
    <p class="m-0">
      <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i data-feather="x-square" class="mr-1"></i>
        <span class="text-body">ログアウト</span>
      </a>
    </p>
  </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
@endsection