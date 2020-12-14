@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">ご利用ガイド</h2>

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

{{-- menu --}}
@include('manage.post.menu')

<form action="{{ route('manage.post.guide.update', ['account' => $sub_domain]) }}" method="post" class="mt-4">
  @csrf
  <textarea name="guide_content" id="editor">
    @if ($contents !== null)
    {!! e($contents->contents) !!}
    @endif
  </textarea>
  <div class="mt-4">
    <button class="btn btn-success text-white px-5 py-2">保存する</button>
  </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create(document.querySelector('#editor'), {
  toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'numberedList'],
})
.catch(error => {
    console.error(error);
});
</script>
@endsection