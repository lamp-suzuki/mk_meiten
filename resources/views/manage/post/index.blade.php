@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">お知らせ一覧</h2>

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

<div class="item__list">
  <div class="item__list-wrap">
    <div class="item__list-name">
      <a class="btn btn-success text-white float-right" href="{{ route('manage.post.add', ['account' => $sub_domain]) }}">
        <i class="d-inline-block align-middle" data-feather="plus-circle"></i>
        <span class="d-inline-block align-middle">新規追加</span>
      </a>
    </div>
    <div class="table-responsive">
      <table class="item__list-table">
        <thead>
          <tr>
            <th class="">タイトル</th>
            <th class="text-nowrap">ステータス</th>
            <th class="text-nowrap">公開日</th>
            <th class="text-nowrap edit">編集</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
          <tr>
            <td>{{ $post->title }}</td>
            <td>公開日</td>
            <td>{{ date('Y-m-d', strtotime($post->created_at)) }}</td>
            <td>
              <form action="{{ route('manage.post.edit', ['account' => $sub_domain]) }}" method="post">
                @csrf
                <input type="hidden" name="posts_id" value="{{ $post->id }}">
                <button type="submit" class="edit">
                  <i data-feather="edit-2"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection