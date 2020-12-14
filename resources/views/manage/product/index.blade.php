@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">商品の追加・編集</h2>

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
@include('manage.product.menu')

<form class="form-inline bg-white p-3">
  @csrf
  <input type="search" class="form-control mr-2 bg-light" id="product_search" placeholder="商品名で検索" style="width: 60%;" />
  <button type="button" class="btn btn-primary" id="product_search_btn">
    <i data-feather="search"></i>
    <span>絞り込み</span>
  </button>
</form>

<div class="item-cats">
  @foreach ($categories as $cat)
  <a href="#cat-{{ $cat->id }}">{{ $cat->name }}</a>
  @endforeach
</div>

<div class="item__list">
  @foreach ($categories as $cat)
  <div class="item__list-wrap" id="cat-{{ $cat->id }}">
    <h3 class="item__list-name">
      <span>{{ $cat->name }}</span>
      <a class="btn btn-success text-white float-right"
        href="{{ route('manage.product.item.add', ['account' => $sub_domain]) }}?cat_id={{ $cat->id }}">
        <i class="d-inline-block align-middle" data-feather="plus-circle"></i>
        <span class="d-inline-block align-middle">新規追加</span>
      </a>
    </h3>
    <table class="item__list-table js-search-table">
      <thead>
        <tr>
          <th>画像</th>
          <th>状態</th>
          <th>商品名</th>
          <th>価格</th>
          <th class="edit">編集</th>
        </tr>
      </thead>
      <tbody class="js-sort-table-menu">
        @if (isset($menus[(int)$cat->id]))
        @foreach ($menus[(int)$cat->id] as $menu)
        <tr data-id="{{ $menu->id }}">
          <td>
            @if ($menu->thumbnail_1 != null)
            <img class="item__list-thumbnail" src="{{ url($menu->thumbnail_1) }}" alt="{{ $menu->name }}" />
            @endif
          </td>
          <td class="text-nowrap">
            @if ($menu->status == 'draft')
            下書き
            @elseif ($menu->status == 'reserve')
            公開予約
            @else
            公開
            @endif
          </td>
          <td class="name">{{ $menu->name }}</td>
          <td>
            <span class="price">{{ number_format($menu->price) }}</span>
          </td>
          <td>
            <a href="{{ route('manage.product.item.edit', ['account' => $sub_domain, 'id' => $menu->id]) }}" class="edit">
              <i data-feather="edit-2"></i>
            </a>
          </td>
        </tr>
        @endforeach
        @endif
      </tbody>
    </table>
  </div>
  <!-- .item__list-wrap -->
  @endforeach
</div>
<!-- .item__list -->
@endsection