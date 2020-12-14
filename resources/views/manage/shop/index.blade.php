@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">店舗の追加・編集</h2>

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

<div class="item__list">
  <div class="item__list-wrap">
    <div class="item__list-name">
      <a class="btn btn-success text-white float-right" href="{{ route('manage.shop.add', ['account' => $sub_domain]) }}">
        <i class="d-inline-block align-middle" data-feather="plus-circle"></i>
        <span class="d-inline-block align-middle">新規追加</span>
      </a>
    </div>
    <div class="table-responsive">
      <table class="item__list-table">
        <thead>
          <tr>
            <th class="">店舗名</th>
            <th class="edit">編集</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($shops as $shop)
          <tr>
            <td>{{ $shop->name }}</td>
            <td>
              <form action="{{ route('manage.shop.edit', ['account' => $sub_domain]) }}" method="post">
                @csrf
                <input type="hidden" name="shops_id" value="{{ $shop->id }}">
                <button class="edit" type="submit">
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