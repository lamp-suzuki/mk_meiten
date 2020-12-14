@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">設定</h2>

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
@include('manage.setting.menu')

<form class="mt-4" action="{{ route('manage.setting.update', ['account' => $sub_domain]) }}" method="post" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="manage_id" value="{{ $manage->id }}">
  <h3 class="font-weight-bold h5 mb-3">店舗について</h3>
  <div class="form-group">
    <label for="name">ショップ名または会社名</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $manage->name }}" required />
  </div>
  <div class="form-group">
    <label for="email">メールアドレス（ログイン・通知用）</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ $manage->email }}" required />
  </div>
  <div class="form-group">
    <label for="tel">電話番号</label>
    <input type="tel" class="form-control" id="tel" name="tel" value="{{ $manage->tel }}" required />
  </div>
  <div class="form-group">
    <label for="fax">FAX（通知用）</label>
    <input type="tel" class="form-control" id="fax" name="fax" value="{{ $manage->fax }}" />
  </div>
  <div class="form-group">
    <label for="description">ショップの説明</label>
    <textarea name="description" class="form-control" id="description" cols="30"
      rows="5">{{ $manage->description }}</textarea>
  </div>
  <div class="form-group">
    <label for="">ロゴ</label>
    <label class="form-img-label d-inline-block align-middle m-0" for="logo">
      <input type="file" name="logo" accept=".jpg, .jpeg, .png, .gif" class="form-img-input form-img-change" id="logo" />
    </label>
    <div class="form-img-preview d-inline-block align-middle ml-2">
      @if ($manage->logo != null)
      <img src="{{ url('/') }}/{{ $manage->logo }}" width="100">
      <input type="hidden" name="logo_flag" value="true">
      @endif
    </div>
  </div>
  <div class="form-group">
    <label for="">販売する料理のカテゴリ</label>
    <select name="genres_id" class="form-control" id="" required>
      @foreach ($genres as $genre)
      <option value="{{ $genre->id }}" @if ($genre->id === $manage->genres_id) selected @endif>{{ $genre->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="default_tax">デフォルト税率</label>
    <select name="default_tax" class="form-control" id="default_tax">
      <option value="8" @if (8===$manage->default_tax) selected @endif>8%</option>
      <option value="10" @if (10===$manage->default_tax) selected @endif>10%</option>
    </select>
  </div>
  <div class="form-group">
    <label for="takeout_flag">対応サービス</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" name="takeout_flag" id="takeout_flag" @if(1===$manage->takeout_flag) checked @endif/>
      <label class="form-check-label text-body" for="takeout_flag">お持ち帰り</label>
    </div>
    <div class="form-check d-none">
      <input class="form-check-input" type="checkbox" value="1" name="delivery_flag" id="delivery_flag" @if(1===$manage->delivery_flag) checked @endif/>
      <label class="form-check-label text-body" for="delivery_flag">デリバリー</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" name="ec_flag" id="ec_flag" @if (1===$manage->ec_flag)
      checked @endif/>
      <label class="form-check-label text-body" for="ec_flag">デリバリー</label>
    </div>
  </div>
  <div class="form-group d-none">
    <label for="">ポイント発行</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="point_flag" id="point_flag_false" value="0" id="" @if(0===$manage->point_flag) checked @endif/>
      <label class="form-check-label text-body" for="point_flag_false">しない</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="point_flag" id="point_flag_true" value="1" id="" @if(1===$manage->point_flag) checked @endif/>
      <label class="form-check-label text-body" for="point_flag_true">する</label>
    </div>
  </div>
  <div class="form-group d-none">
    <label for="default_stock">デフォルト在庫数</label>
    <input type="number" class="form-control w-auto" min="0" max="99999" name="default_stock" id="default_stock"
      value="{{ $manage->default_stock }}" required />
  </div>
  <div class="form-group d-none">
    <label for="">サイト内でお酒を販売しますか？</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="alcohol_flag" id="alcoholFlagTrue" value="0" id="" @if(0===$manage->alcohol_flag) checked @endif/>
      <label class="form-check-label text-body" for="alcoholFlagTrue">販売しない</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="alcohol_flag" id="alcoholFlagFalse" value="1" id="" @if(1===$manage->alcohol_flag) checked @endif/>
      <label class="form-check-label text-body" for="alcoholFlagFalse">販売する</label>
    </div>
  </div>
  <h3 class="font-weight-bold h5 mb-3 mt-4 d-none">SNSについて</h3>
  <div class="form-group row align-items-center mx-0 d-none">
    <label for="facebook" class="col-3 m-0 px-0">Facebook</label>
    <div class="col-9 px-0">
      <input type="text" name="facebook_url" class="form-control" id="facebook" value="{{ $manage->facebook }}" />
    </div>
  </div>
  <div class="form-group row align-items-center mx-0 d-none">
    <label for="twitter" class="col-3 m-0 px-0">Twitter</label>
    <div class="col-9 px-0">
      <input type="text" name="twitter_url" class="form-control" id="twitter" value="{{ $manage->twitter }}" />
    </div>
  </div>
  <div class="form-group row align-items-center mx-0 d-none">
    <label for="instagram" class="col-3 m-0 px-0">Instagram</label>
    <div class="col-9 px-0">
      <input type="text" name="instagram_url" class="form-control" id="instagram" value="{{ $manage->instagram }}" />
    </div>
  </div>
  <h3 class="font-weight-bold h5 mb-3 mt-4 d-none">振込口座について</h3>
  <div class="form-group d-none">
    <label for="account_holder">振込先の口座名義</label>
    <input type="text" class="form-control" id="account_holder" name="account_holder" />
  </div>
  <div class="form-group d-none">
    <label for="fi_name">金融機関名</label>
    <input type="text" class="form-control" id="fi_name" name="fi_name" />
  </div>
  <div class="form-group d-none">
    <label for="branch_name">支店名</label>
    <input type="text" class="form-control" id="branch_name" name="branch_name" />
  </div>
  <div class="form-group d-none">
    <label for="account_type">預金種別</label>
    <select class="form-control w-auto" name="account_type" id="account_type">
      <option value="">--</option>
      <option value="普通">普通</option>
      <option value="定期">定期</option>
    </select>
  </div>
  <div class="form-group d-none">
    <label for="account_number">口座番号</label>
    <input type="text" class="form-control" id="account_number" name="account_number" />
  </div>
  <div class="mt-4 text-center">
    <button type="submit" class="btn btn-success text-white px-5">更新する</button>
  </div>
</form>
@endsection