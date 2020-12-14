@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">カテゴリーの追加・編集</h2>

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

<div class="item__list">
  <div class="item__list-wrap border-0">
    <div class="item__list-name">
      <button class="btn btn-success text-white float-right" data-toggle="modal" data-target="#addCategory">
        <i class="d-inline-block align-middle" data-feather="plus-circle"></i>
        <span class="d-inline-block align-middle">新規追加</span>
      </button>
    </div>
    <div class="table-responsive">
      <table class="item__list-table table border-0">
        <thead>
          <tr>
            <th class="border-0 text-nowrap">カテゴリ名</th>
            <th class="border-0">通知メール</th>
            <th class="border-0">通知電話番号</th>
            <th class="border-0">通知FAX</th>
            <th class="border-0 edit">編集</th>
            <th class="border-0 delete">削除</th>
          </tr>
        </thead>
        <tbody class="js-sort-table-cat">
          @foreach ($categories as $cat)
          <tr data-id="{{ $cat->id }}">
            <td>{{ $cat->name }}</td>
            <td>{{ $cat->notice_email }}</td>
            <td>{{ $cat->notice_tel }}</td>
            <td>{{ $cat->notice_fax }}</td>
            <td>
              <button class="edit" data-toggle="modal" data-target="#editCategory" data-name="{{ $cat->name }}"
                data-id="{{ $cat->id }}" data-email="{{ $cat->notice_email }}" data-tel="{{ $cat->notice_tel }}"
                data-fax="{{ $cat->notice_fax }}">
                <i data-feather="edit-2"></i>
              </button>
            </td>
            <td>
              <form class="js-delete-form"
                action="{{ route('manage.product.category.delete', ['account' => $sub_domain]) }}" method="post">
                @csrf
                <input type="hidden" name="category_id" value="{{ $cat->id }}">
                <button type="submit" class="delete">
                  <i data-feather="trash-2"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <!-- .item__list-wrap -->
</div>
<!-- .item__list -->

<!-- AddModal -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" action="{{ route('manage.product.category.add', ['account' => $sub_domain]) }}"
      method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryLabel">カテゴリ新規追加</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input class="form-control border" type="text" name="category_name" placeholder="カテゴリ名" required>
        <input class="form-control border mt-2" type="email" name="notice_email" placeholder="通知メール" required>
        <input class="form-control border mt-2" type="tel" name="notice_tel" placeholder="通知電話番号(ハイフン無し半角数字)">
        <input class="form-control border mt-2" type="tel" name="notice_fax" placeholder="通知FAX(ハイフン無し半角数字)">
        <input type="hidden" name="manage_id" value="{{ Auth::user()->id }}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <button type="submit" class="btn btn-primary">追加する</button>
      </div>
    </form>
  </div>
</div>

<!-- EditModal -->
<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="edit-category-form" class="modal-content"
      action="{{ route('manage.product.category.edit', ['account' => $sub_domain]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryLabel">カテゴリ編集</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input class="form-control border" type="text" name="category_name" value="" required>
        <input class="form-control border mt-2" type="email" name="notice_email" placeholder="通知メール" required>
        <input class="form-control border mt-2" type="tel" name="notice_tel" placeholder="通知電話番号">
        <input class="form-control border mt-2" type="tel" name="notice_fax" placeholder="通知FAX">
        <input type="hidden" name="category_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <button type="submit" class="btn btn-primary">保存する</button>
      </div>
    </form>
  </div>
</div>
@endsection