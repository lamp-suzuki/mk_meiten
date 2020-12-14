@extends('layouts.manage.app')

@section('content')
<h2 class="h5 text-center font-weight-bold mb-4">こちらの内容で商品を@if (isset($inputs['draft']))
  下書き保存
  @else
  公開
  @endif します。</h2>
<form action="{{ route('manage.product.item.save', ['account' => $sub_domain]) }}" method="post">
  @csrf
  <div class="p-4 rounded-lg bg-white">
    <div class="form-group">
      <label for="">商品名</label>
      <span>{{ $inputs['name'] }}</span>
      <input type="hidden" name="name" value="{{ $inputs['name'] }}" />
    </div>
    <div class="form-group">
      <label for="">商品価格（税込）</label>
      <span>{{ number_format($inputs['price']) }}円</span>
      <input type="hidden" name="price" value="{{ $inputs['price'] }}" />
    </div>
    <div class="form-group">
      <label for="">商品単位</label>
      @if ($inputs['unit'] === null)
      <span>個</span>
      <input type="hidden" name="unit" value="個" />
      @else
      <span>{{ $inputs['unit'] }}</span>
      <input type="hidden" name="unit" value="{{ $inputs['unit'] }}" />
      @endif
    </div>
    <div class="form-group">
      <label for="">商品説明</label>
      <span>{{ $inputs['explanation'] }}</span>
      <input type="hidden" name="explanation" value="{{ $inputs['explanation'] }}">
    </div>
    <div class="form-group">
      <label for="">1日の在庫数</label>
      <span>{{ $inputs['stock'] }}</span>
      <input type="hidden" name="stock" value="{{ $inputs['stock'] }}">
    </div>
    <div class="form-group">
      <label for="">リードタイム</label>
      <span>{{ $inputs['lead_time'] }}分</span>
      <input type="hidden" name="lead_time" value="{{ $inputs['lead_time'] }}">
    </div>
    @if (isset($inputs['item_option']))
    <div class="form-group">
      <label for="">オプション表示</label>
      @php
      $options_id = '';
      @endphp
      @foreach ($inputs['item_option'] as $opt)
      <span>{{ explode(':', $opt)[1] }},</span>
      @php
      $options_id .= explode(':', $opt)[0].',';
      @endphp
      @endforeach
      <input type="hidden" name="options_id" value="{{ $options_id }}">
    </div>
    @endif
    <div class="form-group">
      <label for="">画像</label>
      <div class="row mx-0 px-0">
        @foreach ($thumbnails as $thumbnail)
        <div class="col-4 mx-0 px-1">
          <img src="/storage/{{ str_replace('public/', '', $thumbnail) }}" alt="">
        </div>
        @endforeach
      </div>
    </div>
    <div class="form-group">
      <label for="">対応サービス</label>
      @if (isset($inputs['takeout_flag']))
      <span class="d-inline-block">お持ち帰り</span>
      @endif
      @if (isset($inputs['ec_flag']))
      <span class="d-inline-block">、デリバリー</span>
      @endif
    </div>
    <div class="form-group">
      <label for="">販売店舗設定</label>
      @php
      $shop_ids = '';
      @endphp
      @foreach ($shops as $shop)
      @php
      $shop_ids .= $shop->id.',';
      @endphp
      <span>{{ $shop->name }}、</span>
      @endforeach
      <input type="hidden" name="shop_id" value="{{ $shop_ids }}">
    </div>
    <div class="form-group">
      <label for="">公開日</label>
      @if ((isset($inputs['release_start']) && isset($inputs['release_end'])) && ($inputs['release_start'] !== null && $inputs['release_end'] !== null))
      <span>{{ $inputs['release_start'] }}〜{{ $inputs['release_end'] }}</span>
      <input type="hidden" name="release_start" value="{{ $inputs['release_start'] }}">
      <input type="hidden" name="release_end" value="{{ $inputs['release_end'] }}">
      @else
      <input type="hidden" name="release_start" value="">
      <input type="hidden" name="release_end" value="">
      @endif
    </div>
  </div>

  <input type="hidden" name="category_id" value="{{ $inputs['category_id'] }}" />
  <input type="hidden" name="category_name" value="{{ $inputs['category_name'] }}" />
  @foreach ($thumbnails as $key => $thumbnail)
  <input type="hidden" name="thumbnail_{{ $key+1 }}" value="{{ $thumbnail }}" />
  @endforeach
  @if (isset($inputs['takeout_flag']))
  <input type="hidden" value="1" name="takeout_flag" />
  @endif
  @if (isset($inputs['delivery_flag']))
  <input type="hidden" value="1" name="delivery_flag" />
  @endif
  @if (isset($inputs['ec_flag']))
  <input type="hidden" value="1" name="ec_flag" />
  @endif
  @if (isset($inputs['action']) && $inputs['action'] == 'update')
  <input type="hidden" name="update" value="true">
  @endif
  @if (isset($inputs['menus_id']))
  <input type="hidden" name="menus_id" value="{{ $inputs['menus_id'] }}">
  @endif
  @if (isset($inputs['draft']))
  <input type="hidden" name="draft" value="draft">
  @endif

  <div class="text-center mt-4">
    <button type="submit" name="action" value="send" class="btn bnt-lg btn-success text-white px-5">@if (isset($inputs['draft']))
      保存する
      @else
      公開する
      @endif</button>
    <input type="submit" name="action" value="前のページに戻る"
      class="btn btn-link btn-block font-weight-normal text-body mt-3 small">
  </div>
</form>
@endsection