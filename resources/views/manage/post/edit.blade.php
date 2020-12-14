@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">お知らせ編集</h2>

<form action="{{ route('manage.post.delete', ['account' => $sub_domain]) }}" name="delete" method="post">
  @csrf
  <input type="hidden" name="posts_id" value="{{ $post->id }}">
</form>

<form class="mt-4" action="{{ route('manage.post.confirm', ['account' => $sub_domain]) }}" name="public" method="post"
  enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="title">タイトル<span class="badge badge-warning text-white ml-1">必須</span></label>
    <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required />
  </div>
  <div class="form-group">
    <label for="thumbnail">アイキャッチ</label>
    <input type="file" class="form-control-file" name="thumbnail" id="thumbnail">
  </div>
  <div class="form-group">
    <label for="content">本文<span class="badge badge-warning text-white ml-1">必須</span></label>
    <textarea class="form-control" name="content" id="content" cols="30" rows="10"
      required>{{ $post->content }}</textarea>
  </div>
  <div class="form-group">
    <label for="created_at">公開日<span class="badge badge-warning text-white ml-1">必須</span></label>
    <input type="date" name="created_at" class="form-control w-auto" id="created_at"
      value="{{ date('Y-m-d', strtotime($post->created_at)) }}">
  </div>
  <input type="hidden" name="action" value="update">
  <input type="hidden" name="posts_id" value="{{ $post->id }}">

  <div class="mt-4 d-flex">
    <button type="submit" class="btn btn-success text-white px-5" id="btnPublic">確認する</button>
    <button type="button" class="btn btn-danger ml-auto text-white" id="btnDelete">削除する</button>
  </div>
</form>

<script language="javascript" type="text/javascript">
  const btnPublic = document.getElementById('btnPublic');
  const btnDelete = document.getElementById('btnDelete');

  // 実行
  btnPublic.addEventListener('click', (e) => { // 公開
    e.preventDefault();
    document.public.submit();
  });

  btnDelete.addEventListener('click', (e) => { //削除
    e.preventDefault();
    if (window.confirm('削除してもよろしいでしょうか？')) {
      document.delete.submit();
    } else {
      return false;
    }
  });
</script>
@endsection