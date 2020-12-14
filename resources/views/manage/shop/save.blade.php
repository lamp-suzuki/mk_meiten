@extends('layouts.manage.app')

@section('content')

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

@if(isset($action))
<h2 class="h5 text-center font-weight-bold mb-4">店舗を更新しました。</h2>
@else
<h2 class="h5 text-center font-weight-bold mb-4">店舗を追加しました。</h2>
@endif
<div class="p-3 rounded-lg bg-white row col-lg-9 mx-auto text-center">
  <p class="font-weight-bold mb-0 mx-auto">{{ $name }}</p>
</div>
<div class="text-center mt-4">
  <a class="btn btn-link text-body font-weight-normal" href="{{ route('manage.shop.index', ['account' => $sub_domain]) }}">一覧に戻る</a>
</div>
@endsection