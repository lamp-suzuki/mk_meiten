@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">お知らせ投稿確認</h2>

<form class="mt-4" action="{{ route('manage.post.save', ['account' => $sub_domain]) }}" method="post">
  @csrf
  <div class="p-4 rounded-lg bg-white">
    <div class="form-group">
      <label for="title">タイトル<span class="badge badge-warning text-white ml-1">必須</span></label>
      <span>{{ $inputs['title'] }}</span>
      <input type="hidden" name="title" id="title" value="{{ $inputs['title'] }}" />
    </div>
    @if ($thumbnail != null)
    <div class="form-group">
      <label for="thumbnail">アイキャッチ</label>
      <img width="200" src="/storage/{{ str_replace('public/', '', $thumbnail) }}" alt="{{ $inputs['title'] }}">
      <input type="hidden" name="thumbnail" id="thumbnail" value="{{ $thumbnail }}">
    </div>
    @endif
    <div class="form-group">
      <label for="content">本文<span class="badge badge-warning text-white ml-1">必須</span></label>
      <textarea class="form-control" name="content" id="content" cols="30" rows="10"
        readonly>{{ $inputs['content'] }}</textarea>
    </div>
    <div class="form-group">
      <label for="created_at">公開日<span class="badge badge-warning text-white ml-1">必須</span></label>
      <input type="date" name="created_at" class="form-control w-auto" id="created_at"
        value="{{ $inputs['created_at'] }}" readonly>
    </div>
  </div>

  @isset($inputs['action'])
  <input type="hidden" name="action" value="update">
  @endisset
  @isset($inputs['posts_id'])
  <input type="hidden" name="posts_id" value="{{ $inputs['posts_id'] }}">
  @endisset

  <div class="mt-4 text-center">
    <button type="submit" class="btn btn-success text-white px-5">公開する</button>
  </div>
</form>
@endsection