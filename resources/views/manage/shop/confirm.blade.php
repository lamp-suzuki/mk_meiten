@extends('layouts.manage.app')

@php
$weeks = ['sun' => '日','mon' => '月','tue' => '火','wed' => '水','thu' => '木','fri' => '金','sat' => '土'];
@endphp

@section('content')
<h2 class="h5 text-center font-weight-bold mb-4">こちらの内容で店舗を追加します。</h2>
<form action="{{ route('manage.shop.save', ['account' => $sub_domain]) }}" method="post">
  @csrf
  <div class="p-4 rounded-lg bg-white">
    <h3 class="font-weight-bold h5 mb-3">1. 基本情報</h3>
    <div class="form-group">
      <label for="name">店舗名</label>
      <span>{{ $inputs['name'] }}</span>
      <input type="hidden" id="name" name="name" value="{{ $inputs['name'] }}" />
    </div>
    <div class="form-group">
      <label for="tel">電話番号</label>
      <span>{{ $inputs['tel'] }}</span>
      <input type="hidden" id="tel" name="tel" value="{{ $inputs['tel'] }}" />
    </div>
    <div class="form-group">
      <label for="email">メールアドレス</label>
      <span>{{ $inputs['email'] }}</span>
      <input type="hidden" id="email" name="email" value="{{ $inputs['email'] }}" />
    </div>
    <h3 class="font-weight-bold h5 mb-3 mt-4">2. 住所について</h3>
    <div class="form-group">
      <label for="zipcode">郵便番号</label>
      <span>〒{{ $inputs['zipcode'] }}</span>
      <input type="hidden" id="zipcode" name="zipcode" value="{{ $inputs['zipcode'] }}">
    </div>
    <div class="form-group">
      <label for="pref">都道府県</label>
      <span>{{ $inputs['pref'] }}</span>
      <input type="hidden" id="pref" name="pref" value="{{ $inputs['pref'] }}">
    </div>
    <div class="form-group">
      <label for="address1">市区町村</label>
      <span>{{ $inputs['address1'] }}</span>
      <input type="hidden" id="address1" name="address1" value="{{ $inputs['address1'] }}" />
    </div>
    <div class="form-group">
      <label for="address1">番地建物名</label>
      <span>{{ $inputs['address2'] }}</span>
      <input type="hidden" id="address2" name="address2" value="{{ $inputs['address2'] }}" />
    </div>
    <div class="form-group">
      <label for="access">アクセス</label>
      <textarea name="access" class="form-control" id="access" rows="5" readonly>{{ $inputs['access'] }}</textarea>
    </div>
    <div class="form-group">
      <label for="googlemap_url">GoogleMapURL</label>
      <span>{{ $inputs['googlemap_url'] }}</span>
      <input type="hidden" id="googlemap_url" name="googlemap_url" value="{{ $inputs['googlemap_url'] }}" />
    </div>
    <h3 class="font-weight-bold h5 mb-3 mt-4">3. お支払い方法</h3>
    <div class="form-group">
      <label for="payment">対応決済方法</label>
      <div class="form-check px-0 py-1">
        <input class="form-check-input" type="checkbox" value="1" id="payment1" name="payment1" @isset($inputs['payment1']) checked @endisset />
        <label class="form-check-label text-body" for="payment1">オンライン決済</label>
      </div>
      <div class="form-check px-0 py-1">
        <input class="form-check-input" type="checkbox" value="2" id="payment2" name="payment2" @isset($inputs['payment2']) checked @endisset />
        <label class="form-check-label text-body" for="payment2">店頭でお支払い</label>
      </div>
    </div>
    <h3 class="font-weight-bold h5 mb-3 mt-4">4. その他</h3>
    <div class="form-group">
      <label for="parking">駐車場について</label>
      <span>{{ $inputs['parking'] }}</span>
      <input type="hidden" id="parking" name="parking" value="{{ $inputs['parking'] }}" />
    </div>
    <h3 class="font-weight-bold h5 mb-3 mt-4">5. 営業日時</h3>
    <div class="form-group">
      <label>お持ち帰り</label>
      <p>ご注文受け付け時間：{{ $inputs['takeout_preparation'] }}分前</p>
      <input type="hidden" name="takeout_preparation" value="{{ $inputs['takeout_preparation'] }}">
      @foreach ($weeks as $id => $week)
      @if (isset($inputs['takeout_'.$id]))
      <span class="d-block mb-2">
        ({{ $week }})
        ランチ{{ $inputs['takeout_lunch_start_hours_'.$id] }}:{{ $inputs['takeout_lunch_start_seconds_'.$id] }}〜{{ $inputs['takeout_lunch_end_hours_'.$id] }}:{{ $inputs['takeout_lunch_end_seconds_'.$id] }}、
        ディナー{{ $inputs['takeout_dinner_start_hours_'.$id] }}:{{ $inputs['takeout_dinner_start_seconds_'.$id] }}〜{{ $inputs['takeout_dinner_end_hours_'.$id] }}:{{ $inputs['takeout_dinner_end_seconds_'.$id] }}
      </span>
      <input type="hidden" name="takeout_{{$id}}" value="{{ $inputs['takeout_lunch_start_hours_'.$id] }}:{{ $inputs['takeout_lunch_start_seconds_'.$id] }},{{ $inputs['takeout_lunch_end_hours_'.$id] }}:{{ $inputs['takeout_lunch_end_seconds_'.$id] }},{{ $inputs['takeout_dinner_start_hours_'.$id] }}:{{ $inputs['takeout_dinner_start_seconds_'.$id] }},{{ $inputs['takeout_dinner_end_hours_'.$id] }}:{{ $inputs['takeout_dinner_end_seconds_'.$id] }}">
      @endif
      @endforeach
    </div>
    {{-- <div class="form-group">
      <label>デリバリー</label>
      <p>ご注文受け付け時間：{{ $inputs['delivery_preparation'] }}分前</p>
      <input type="hidden" name="delivery_preparation" value="{{ $inputs['delivery_preparation'] }}">
      <p>送料：{{ $inputs['delivery_shipping'] }}円</p>
      <input type="hidden" name="delivery_shipping" value="{{ $inputs['delivery_shipping'] }}">
      <p>送料無料設定：{{ $inputs['delivery_shipping_free'] }}円</p>
      <input type="hidden" name="delivery_shipping_free" value="{{ $inputs['delivery_shipping_free'] }}">
      @foreach ($weeks as $id => $week)
      @if (isset($inputs['delivery_'.$id]))
      <span class="d-block mb-2">
        ({{ $week }})
        ランチ{{ $inputs['delivery_lunch_start_hours_'.$id] }}:{{ $inputs['delivery_lunch_start_seconds_'.$id] }}〜{{ $inputs['delivery_lunch_end_hours_'.$id] }}:{{ $inputs['delivery_lunch_end_seconds_'.$id] }}、
        ディナー{{ $inputs['delivery_dinner_start_hours_'.$id] }}:{{ $inputs['delivery_dinner_start_seconds_'.$id] }}〜{{ $inputs['delivery_dinner_end_hours_'.$id] }}:{{ $inputs['delivery_dinner_end_seconds_'.$id] }}
      </span>
      <input type="hidden" name="delivery_{{$id}}" value="{{ $inputs['delivery_lunch_start_hours_'.$id] }}:{{ $inputs['delivery_lunch_start_seconds_'.$id] }},{{ $inputs['delivery_lunch_end_hours_'.$id] }}:{{ $inputs['delivery_lunch_end_seconds_'.$id] }},{{ $inputs['delivery_dinner_start_hours_'.$id] }}:{{ $inputs['delivery_dinner_start_seconds_'.$id] }},{{ $inputs['delivery_dinner_end_hours_'.$id] }}:{{ $inputs['delivery_dinner_end_seconds_'.$id] }}">
      @endif
      @endforeach
    </div> --}}
  </div>

  <div class="mt-4 text-center">
    @if(isset($inputs['action']))
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="shops_id" value="{{ $inputs['shops_id'] }}">
    <button type="submit" class="btn btn-success text-white px-5">更新する</button>
    @else
    <button type="submit" class="btn btn-success text-white px-5">追加する</button>
    @endif
  </div>
</form>
@endsection