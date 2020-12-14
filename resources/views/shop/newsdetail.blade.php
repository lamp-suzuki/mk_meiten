@extends('layouts.shop.app')

@section('page_title', $news->title)

@section('content')
<section class="mv">
  <div class="container">
    <h2>お知らせ</h2>
  </div>
</section>
<article class="bg-white py-4 rounded mb-5">
  <div class="container">
    <h2 class="h5 font-weight-bold">{{ $news->title }}</h2>
    <p class="text-muted small">{{ date('Y.m.d', strtotime($news->updated_at)) }}</p>
    <p>{!! nl2br(e($news->content)) !!}</p>
    <div class="mt-4 text-center">
      <a class="btn btn-primary rounded-pill" href="{{ route('shop.news', ['account' => $sub_domain]) }}">一覧に戻る</a>
    </div>
  </div>
</article>
@endsection