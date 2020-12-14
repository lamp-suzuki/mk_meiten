@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">商品の新規追加</h2>

<form action="{{ route('manage.product.item.confirm', ['account' => $sub_domain]) }}" method="post" enctype="multipart/form-data">
  @csrf
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
      value="{{ old('name') }}" placeholder="" />
    @error('name')
    <div class="invalid-feedback">必須項目です。</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="itemPrice">
      商品価格（税別）
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="input-group w-50 @error('price') is-invalid @enderror">
      <input type="number" class="form-control @error('price') is-invalid @enderror" id="itemPrice" name="price"
        value="{{ old('price') }}" placeholder="" />
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
    <input type="text" class="form-control w-auto" id="itemUnit" name="unit" value="{{ old('unit') }}"
      placeholder="個" />
  </div>
  <div class="form-group">
    <label for="itemDesc">商品説明</label>
    <textarea class="form-control" id="itemDesc" name="explanation" rows="10">{{ old('explanation') }}</textarea>
  </div>
  <div class="form-group">
    <label for="item-stock">
      1日の在庫数
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="form-row align-items-center">
      <div class="col-auto">
        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="item-stock" name="stock"
          min="0" value="99" />
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
    <div class="input-group w-50 @error('lead_time') is-invalid @enderror">
      <input type="number" class="form-control @error('lead_time') is-invalid @enderror" id="lead_time" name="lead_time" value="{{ old('lead_time') }}" placeholder="" />
      <div class="input-group-prepend">
        <div class="input-group-text">分</div>
      </div>
    </div>
    @error('lead_time')
    <div class="invalid-feedback">必須項目です。</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="">オプション表示</label>
    @foreach ($options as $opt)
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="item_option[]" value="{{ $opt->id }}:{{ $opt->name }}"
        id="opt{{ $opt->id }}" />
      <label class="form-check-label text-body" for="opt{{ $opt->id }}">{{ $opt->name }}</label>
    </div>
    @endforeach
  </div>
  <div class="form-group">
    <label for="">画像</label>
    <input type="file" class="form-control-file" name="thumbnail_1" id="thumbnail_1">
    <input type="file" class="form-control-file mt-2" name="thumbnail_2" id="thumbnail_2">
    <input type="file" class="form-control-file mt-2" name="thumbnail_3" id="thumbnail_3">
    {{-- <div class="form-img">
      <label class="form-img-label" for="thumbnail_1">
        <input type="file" name="thumbnail_1" accept=".jpg, .jpeg, .png, .gif" class="form-img-input" id="thumbnail_1" />
      </label>
      <label class="form-img-label" for="thumbnail_2">
        <input type="file" name="thumbnail_2" accept=".jpg, .jpeg, .png, .gif" class="form-img-input" id="thumbnail_2" />
      </label>
      <label class="form-img-label" for="thumbnail_3">
        <input type="file" name="thumbnail_3" accept=".jpg, .jpeg, .png, .gif" class="form-img-input" id="thumbnail_3" />
      </label>
    </div> --}}
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
      <input class="form-check-input" type="checkbox" value="1" name="takeout_flag" id="takeout_flag" checked />
      <label class="form-check-label text-body" for="takeout_flag">お持ち帰り</label>
    </div>
    <div class="form-check d-none">
      <input class="form-check-input" type="checkbox" value="1" name="delivery_flag" id="delivery_flag" />
      <label class="form-check-label text-body" for="delivery_flag">デリバリー</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" name="ec_flag" id="ec_flag" />
      <label class="form-check-label text-body" for="ec_flag">デリバリー</label>
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
      <option value="{{ $shop->id }}">{{ $shop->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="">販売期間</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="reserve" value="1" id="postPublic" />
      <label class="form-check-label text-body" for="postPublic">販売期間を設定する</label>
    </div>
    <div id="postPublic-date" class="form-date">
      <label for="">販売期間</label>
      <div class="d-flex justify-content-start align-items-center flex-wrap">
        <div class="form-inline">
          <input type="date" name="public_date" value="" class="form-control w-auto mr-2" id="" />
          <input type="number" name="public_time" value="" min="0" max="24" class="form-control w-auto" id=""
            placeholder="23" />
          <span class="mx-1">：</span>
          <input type="number" name="public_second" value="" min="0" max="59" class="form-control w-auto" id=""
            placeholder="59" />
        </div>
        <span class="mx-2">〜</span>
        <div class="form-inline">
          <input type="date" name="public_date" value="" class="form-control w-auto mr-2" id="" />
          <input type="number" name="public_time" value="" min="0" max="24" class="form-control w-auto" id=""
            placeholder="23" />
          <span class="mx-1">：</span>
          <input type="number" name="public_second" value="" min="0" max="59" class="form-control w-auto" id=""
            placeholder="59" />
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex mt-3">
    <button type="button" class="btn bg-white text-success mr-2">下書き保存</button>
    <button type="submit" class="btn btn-success text-white">公開する</button>
  </div>
</form>
@endsection