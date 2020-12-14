@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">オプションの追加・編集</h2>

{{-- menu --}}
@include('manage.product.menu')

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
      <button class="btn btn-success text-white float-right" data-toggle="modal" data-target="#addOption"
        data-id="{{ $cat->id }}">
        <i class="d-inline-block align-middle" data-feather="plus-circle"></i>
        <span class="d-inline-block align-middle">新規追加</span>
      </button>
    </h3>
    <table class="item__list-table">
      <thead>
        <tr>
          <th>オプション名</th>
          <th>価格</th>
          <th class="edit">編集</th>
          <th class="delete">削除</th>
        </tr>
      </thead>
      <tbody>
        @if ($options[$cat->id] !== null)
        @foreach ($options[$cat->id] as $opt)
        <tr>
          <td>{{ $opt->name }}</td>
          <td>
            <span class="price">{{ $opt->price }}</span>
          </td>
          <td>
            <button class="edit" data-toggle="modal" data-target="#editOption" data-name="{{ $opt->name }}" data-id="{{ $opt->id }}" data-price="{{ $opt->price }}">
              <i data-feather="edit-2"></i>
            </button>
          </td>
          <td>
            <form class="js-delete-option" action="{{ route('manage.product.option.delete', ['account' => $sub_domain]) }}" method="post">
              @csrf
              <input type="hidden" name="option_id" value="{{ $opt->id }}">
              <button type="submit" class="delete">
                <i data-feather="trash-2"></i>
              </button>
            </form>
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

<!-- AddModal -->
<div class="modal fade" id="addOption" tabindex="-1" role="dialog" aria-labelledby="addOptionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="add-option-form" class="modal-content" action="{{ route('manage.product.option.add', ['account' => $sub_domain]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addOptionLabel">オプション新規追加</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input class="form-control mb-2" type="text" name="option_name" placeholder="オプション名" required>
        <div class="input-group w-50">
          <input class="form-control" type="number" name="option_price" placeholder="価格" required>
          <div class="input-group-prepend bg-white">
            <div class="input-group-text bg-white">円</div>
          </div>
        </div>
        <input class="form-control" type="hidden" name="category_id" value="" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <button type="submit" class="btn btn-primary">追加する</button>
      </div>
    </form>
  </div>
</div>

<!-- EditModal -->
<div class="modal fade" id="editOption" tabindex="-1" role="dialog" aria-labelledby="editOptionLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="edit-option-form" class="modal-content" action="{{ route('manage.product.option.edit', ['account' => $sub_domain]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="editOptionLabel">オプション編集</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input class="form-control mb-2 border" type="text" name="option_name" value="" required>
        <div class="input-group w-50">
          <input class="form-control border" type="number" name="option_price" value="" required>
          <div class="input-group-prepend bg-white">
            <div class="input-group-text bg-white">円</div>
          </div>
        </div>
        <input type="hidden" name="option_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <button type="submit" class="btn btn-primary">保存する</button>
      </div>
    </form>
  </div>
</div>
@endsection