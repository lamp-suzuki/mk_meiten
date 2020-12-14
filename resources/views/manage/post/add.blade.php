@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">お知らせ追加</h2>

<form class="mt-4" action="{{ route('manage.post.confirm', ['account' => $sub_domain]) }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="title">タイトル<span class="badge badge-warning text-white ml-1">必須</span></label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required />
  </div>
  <div class="form-group">
    <label for="thumbnail">アイキャッチ</label>
    <input type="file" class="form-control-file" name="thumbnail" id="thumbnail">
  </div>
  <div class="form-group">
    <label for="content">本文<span class="badge badge-warning text-white ml-1">必須</span></label>
    <textarea class="form-control" name="content" id="content" cols="30" rows="10" required></textarea>
  </div>
  <div class="form-group">
    <label for="created_at">公開日<span class="badge badge-warning text-white ml-1">必須</span></label>
    <input type="date" name="created_at" class="form-control w-auto" id="created_at" value="{{ date('Y-m-d') }}">
  </div>
  <div class="mt-4 text-center">
    <button type="submit" class="btn btn-success text-white px-5">確認する</button>
  </div>
</form>
@endsection