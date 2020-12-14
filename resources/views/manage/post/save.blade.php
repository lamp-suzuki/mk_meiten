@extends('layouts.manage.app')

@section('content')
<h2 class="h5 text-center font-weight-bold mb-4">お知らせを公開しました。</h2>
<div class="p-3 rounded-lg bg-white row col-lg-9 mx-auto">
  <div class="col-lg-3 col-4 px-0">
    @if ($thumbnail != null)
    <img src="{{ url('/') }}/{{ $thumbnail }}" alt="{{ $title }}">
    @endif
  </div>
  <div class="col-lg-9 col-8 pr-0">
    <p class="font-weight-bold">{{ $title }}</p>
  </div>
</div>
<div class="text-center mt-4">
  <a class="btn btn-link text-body font-weight-normal" href="{{ route('manage.post.index', ['account' => $sub_domain]) }}">一覧に戻る</a>
</div>
@endsection