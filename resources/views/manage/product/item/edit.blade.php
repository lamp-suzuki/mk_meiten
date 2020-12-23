@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">商品の編集</h2>

{{-- 削除用 --}}
<form class="text-right" action="{{ route('manage.product.item.delete', ['account' => $sub_domain]) }}" name="delete" method="post">
  @csrf
  <input type="hidden" name="menu_id" value="{{ $menu->id }}">
</form>

<form action="{{ route('manage.product.item.confirm', ['account' => $sub_domain]) }}" method="post" name="public" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="action" value="update">
  <input type="hidden" name="menus_id" value="{{ $menu->id }}">
  <div class="form-group">
    <label for="">カテゴリ</label>
    <p class="m-0">{{ $category->name }}</p>
    <input type="hidden" name="category_id" value="{{ $category->id }}" />
    <input type="hidden" name="category_name" value="{{ $category->name }}" />
  </div>
  <div class="form-group">
    <label for="itemName">
      商品名
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="itemName" name="name"
      value="{{ $menu->name }}" placeholder="" />
    @error('name')
    <div class="invalid-feedback">必須項目です。</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="itemPrice">
      商品価格（税込）
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="input-group w-50 @error('price') is-invalid @enderror">
      <input type="number" class="form-control @error('price') is-invalid @enderror" id="itemPrice" name="price"
        value="{{ $menu->price }}" placeholder="" />
      <div class="input-group-prepend">
        <div class="input-group-text">円</div>
      </div>
    </div>
    @error('price')
    <div class="invalid-feedback">必須項目です。</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="itemUnit">商品単位</label>
    <input type="text" class="form-control w-auto" id="itemUnit" name="unit" value="{{ $menu->unit }}"
      placeholder="個" />
  </div>
  <div class="form-group">
    <label for="itemDesc">商品説明</label>
    <textarea class="form-control" id="itemDesc" name="explanation" rows="10">{{ $menu->explanation }}</textarea>
  </div>
  <div class="form-group">
    <label for="item-stock">
      1日の在庫数
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="form-row align-items-center">
      <div class="col-auto">
        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="item-stock" name="stock"
          min="0" value="{{ $menu->stock }}" />
      </div>
      <div class="col-auto">
        <button class="btn btn-info text-white" id="stock-btn" type="button" data-id="{{ $menu->id }}" data-manageid="{{ $menu->id }}" data-toggle="modal"
          data-target="#itemCalendar">個別に設定する</button>
      </div>
      @error('stock')
      <div class="invalid-feedback">必須項目です。</div>
      @enderror
    </div>
  </div>
  <div class="form-group">
    <label for="lead_time">
      リードタイム
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="input-group w-50">
      <input type="number" class="form-control" id="lead_time" name="lead_time" value="{{ $menu->lead_time }}"
        placeholder="" />
      <div class="input-group-prepend">
        <div class="input-group-text">分</div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="">オプション表示</label>
    @php
    $product_opt = explode(',', $menu->options_id);
    while(($index = array_search("", $product_opt, true)) !== false) {
        unset($product_opt[$index]);
    }
    @endphp
    @foreach ($options as $key => $opt)
    <div class="form-check">
      <input class="form-check-input"
        type="checkbox"
        name="item_option[]"
        value="{{ $opt->id }}:{{ $opt->name }}"
        id="opt{{ $opt->id }}"
        @if(in_array((String)$opt->id, $product_opt)) checked @endif />
      <label class="form-check-label text-body" for="opt{{ $opt->id }}">{{ $opt->name }}</label>
    </div>
    @endforeach
  </div>
  <div class="form-group">
    <label for="">画像（変更がある場合のみアップロード）</label>
    <input type="file" accept=".jpg, .jpeg, .png, .gif" class="form-control-file" name="thumbnail_1" id="thumbnail_1">
    <input type="file" accept=".jpg, .jpeg, .png, .gif" class="form-control-file mt-2" name="thumbnail_2" id="thumbnail_2">
    <input type="file" accept=".jpg, .jpeg, .png, .gif" class="form-control-file mt-2" name="thumbnail_3" id="thumbnail_3">
    <small class="form-text text-muted d-block">
      ※3枚まで追加できます。
      <br />
      ※幅1204pxの画像を推奨しています。
      <br />
      ※対応ファイル：jpg.png.gif
    </small>
  </div>
  <div class="form-group">
    <label for="">対応サービス</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" name="takeout_flag" id="takeout_flag"
        @if($menu->takeout_flag != null) checked @endif />
      <label class="form-check-label text-body" for="takeout_flag">お持ち帰り</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" name="delivery_flag" id="delivery_flag"
        @if($menu->delivery_flag != null) checked @endif />
      <label class="form-check-label text-body" for="delivery_flag">デリバリー</label>
    </div>
    <div class="form-check d-none">
      <input class="form-check-input" type="checkbox" value="1" name="ec_flag" id="ec_flag" @if($menu->ec_flag != null)
      checked @endif />
      <label class="form-check-label text-body" for="ec_flag">通販</label>
    </div>
  </div>
  <div class="form-group">
    <label for="">販売店舗設定</label>
    <div class="form-check form-check-inline no-bg">
      <input class="form-check-input js-specific-exclusion" type="radio" name="saleshop-flag" id="all-shop" value="0" checked />
      <label class="form-check-label text-body" for="all-shop">すべての店舗で販売</label>
    </div>
    <div class="form-check form-check-inline no-bg">
      <input class="form-check-input js-specific-exclusion" type="radio" name="saleshop-flag" id="specific-shop" value="1" />
      <label class="form-check-label text-body" for="specific-shop">特定の店舗で販売</label>
    </div>
    {{-- <div class="form-check form-check-inline no-bg">
      <input class="form-check-input js-specific-exclusion" type="radio" name="saleshop-flag" id="exclusion-shop" value="2" />
      <label class="form-check-label text-body" for="exclusion-shop">特定の店舗を除外</label>
    </div> --}}
    <div class="my-2"></div>
    <select class="form-control" id="saleshop" name="shops_id[]" multiple="multiple" style="display: none">
      @foreach ($shops as $shop)
      <option value="{{ $shop->id }}"@if (in_array((String)$shop->id, $only_shops)) selected @endif>{{ $shop->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="">販売期間</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="reserve" value="1" id="postPublic" @if($menu->release_start != null && $menu->release_end != null) checked @endif />
      <label class="form-check-label text-body" for="postPublic">販売期間を設定する</label>
    </div>
    <div id="postPublic-date" class="form-date">
      <label for="">販売期間</label>
      <div class="d-flex justify-content-start align-items-center flex-wrap">
        <div class="form-inline">
          <input type="date" name="release_start" value="{{ $menu->release_start != null ? date('Y-m-d', strtotime($menu->release_start)) : '' }}" class="form-control w-auto mr-2" id="release_start" />
        </div>
        <span class="mx-2">〜</span>
        <div class="form-inline">
          <input type="date" name="release_end" value="{{ $menu->release_end != null ? date('Y-m-d', strtotime($menu->release_end)) : '' }}" class="form-control w-auto mr-2" id="release_end" />
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex mt-3">
    <input type="submit" class="btn bg-white text-success mr-2" id="btnDraft" name="draft" value="下書き保存">
    <button type="button" class="btn btn-success text-white" id="btnPublic">公開する</button>
    <button type="button" class="btn btn-danger ml-auto text-white" id="btnDelete">削除する</button>
  </div>
</form>

{{-- カレンダー --}}
<div class="modal fade" id="itemCalendar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="itemCalendarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header align-items-center">
        <h5 class="modal-title font-weight-bold text-center" id="itemCalendarLabel">在庫設定</h5>
        <small class="ml-3">数字をクリックして在庫変更</small>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="calendar"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal">閉じる</button>
      </div>
    </div>
  </div>
</div>

<script>
  const btnPublic = document.getElementById('btnPublic');
  const btnDelete = document.getElementById('btnDelete');

  // 実行
  btnPublic.addEventListener('click', (e) => { // 公開
    e.preventDefault();
    document.public.submit();
  });

  // 削除
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