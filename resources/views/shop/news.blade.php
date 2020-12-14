@extends('layouts.shop.app')

@section('page_title', 'お知らせ')

@section('content')
<section class="mv">
  <div class="container">
    <h2>お知らせ</h2>
  </div>
</section>
<section class="bg-white py-4 rounded mb-5">
  <div class="container">
    @foreach ($news as $n)
    <a class="d-flex mb-2 pb-2 border-bottom" href="{{ route('shop.info', ['account' => $sub_domain, 'id' => $n->id]) }}">
      <span class="text-muted mr-2">{{ date('Y.m.d', strtotime($n->updated_at)) }}</span>
      <span class="text-body">{{ $n->title }}</span>
    </a>
    @endforeach
    @if (count($news) == 0)
    <p class="mb-0 text-center">お知らせがまだ投稿されていません</p>
    @endif
    <div class="text-center mt-4">
      {{ $news->onEachSide(0)->links() }}
    </div>
  </div>
</section>
@endsection