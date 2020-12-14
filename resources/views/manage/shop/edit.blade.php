@extends('layouts.manage.app')

@php
$weeks = ['sun' => '日','mon' => '月','tue' => '火','wed' => '水','thu' => '木','fri' => '金','sat' => '土'];
@endphp

@section('content')
<h2 class="page-ttl">店舗の編集</h2>

<form action="{{ route('manage.shop.delete', ['account' => $sub_domain]) }}" method="post" name="delete">
  @csrf
  <input type="hidden" name="shops_id" value="{{ $shops_id }}">
</form>

<form action="{{ route('manage.shop.confirm', ['account' => $sub_domain]) }}" method="post" name="edit">
  @csrf
  <h3 class="font-weight-bold h5 mb-3">1. 基本情報</h3>
  <div class="form-group">
    <label for="name">
      店舗名
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $shop->name }}" required />
  </div>
  <div class="form-group">
    <label for="tel">
      電話番号
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="tel" class="form-control" id="tel" name="tel" value="{{ $shop->tel }}" required />
  </div>
  <div class="form-group">
    <label for="email">
      メールアドレス
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="email" class="form-control" id="email" name="email" value="{{ $shop->email }}" required />
  </div>
  <h3 class="font-weight-bold h5 mb-3 mt-4">2. 住所について</h3>
  <div class="form-group">
    <label for="zipcode">
      郵便番号
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="input-group w-50 justify-content-start">
      <div class="input-group-prepend">
        <div class="input-group-text">〒</div>
      </div>
      <input type="text" maxlength="8" class="form-control w-50" id="zipcode" name="zipcode"
        value="{{ $shop->zipcode }}" required />
    </div>
  </div>
  <div class="form-group">
    <label for="pref">
      都道府県
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <select name="pref" class="form-control w-auto" id="pref" name="pref" required>
      <option value="">都道府県</option>
      <option value="北海道" @if($shop->pref === '北海道') selected @endif>北海道</option>
      <option value="青森県" @if($shop->pref === '青森県') selected @endif>青森県</option>
      <option value="岩手県" @if($shop->pref === '岩手県') selected @endif>岩手県</option>
      <option value="宮城県" @if($shop->pref === '宮城県') selected @endif>宮城県</option>
      <option value="秋田県" @if($shop->pref === '秋田県') selected @endif>秋田県</option>
      <option value="山形県" @if($shop->pref === '山形県') selected @endif>山形県</option>
      <option value="福島県" @if($shop->pref === '福島県') selected @endif>福島県</option>
      <option value="茨城県" @if($shop->pref === '茨城県') selected @endif>茨城県</option>
      <option value="栃木県" @if($shop->pref === '栃木県') selected @endif>栃木県</option>
      <option value="群馬県" @if($shop->pref === '群馬県') selected @endif>群馬県</option>
      <option value="埼玉県" @if($shop->pref === '埼玉県') selected @endif>埼玉県</option>
      <option value="千葉県" @if($shop->pref === '千葉県') selected @endif>千葉県</option>
      <option value="東京都" @if($shop->pref === '東京都') selected @endif>東京都</option>
      <option value="神奈川県" @if($shop->pref === '神奈川県') selected @endif>神奈川県</option>
      <option value="新潟県" @if($shop->pref === '新潟県') selected @endif>新潟県</option>
      <option value="富山県" @if($shop->pref === '富山県') selected @endif>富山県</option>
      <option value="石川県" @if($shop->pref === '石川県') selected @endif>石川県</option>
      <option value="福井県" @if($shop->pref === '福井県') selected @endif>福井県</option>
      <option value="山梨県" @if($shop->pref === '山梨県') selected @endif>山梨県</option>
      <option value="長野県" @if($shop->pref === '長野県') selected @endif>長野県</option>
      <option value="岐阜県" @if($shop->pref === '岐阜県') selected @endif>岐阜県</option>
      <option value="静岡県" @if($shop->pref === '静岡県') selected @endif>静岡県</option>
      <option value="愛知県" @if($shop->pref === '愛知県') selected @endif>愛知県</option>
      <option value="三重県" @if($shop->pref === '三重県') selected @endif>三重県</option>
      <option value="滋賀県" @if($shop->pref === '滋賀県') selected @endif>滋賀県</option>
      <option value="京都府" @if($shop->pref === '京都府') selected @endif>京都府</option>
      <option value="大阪府" @if($shop->pref === '大阪府') selected @endif>大阪府</option>
      <option value="兵庫県" @if($shop->pref === '兵庫県') selected @endif>兵庫県</option>
      <option value="奈良県" @if($shop->pref === '奈良県') selected @endif>奈良県</option>
      <option value="和歌山県" @if($shop->pref === '和歌山県') selected @endif>和歌山県</option>
      <option value="鳥取県" @if($shop->pref === '鳥取県') selected @endif>鳥取県</option>
      <option value="島根県" @if($shop->pref === '島根県') selected @endif>島根県</option>
      <option value="岡山県" @if($shop->pref === '岡山県') selected @endif>岡山県</option>
      <option value="広島県" @if($shop->pref === '広島県') selected @endif>広島県</option>
      <option value="山口県" @if($shop->pref === '山口県') selected @endif>山口県</option>
      <option value="徳島県" @if($shop->pref === '徳島県') selected @endif>徳島県</option>
      <option value="香川県" @if($shop->pref === '香川県') selected @endif>香川県</option>
      <option value="愛媛県" @if($shop->pref === '愛媛県') selected @endif>愛媛県</option>
      <option value="高知県" @if($shop->pref === '高知県') selected @endif>高知県</option>
      <option value="福岡県" @if($shop->pref === '福岡県') selected @endif>福岡県</option>
      <option value="佐賀県" @if($shop->pref === '佐賀県') selected @endif>佐賀県</option>
      <option value="長崎県" @if($shop->pref === '長崎県') selected @endif>長崎県</option>
      <option value="熊本県" @if($shop->pref === '熊本県') selected @endif>熊本県</option>
      <option value="大分県" @if($shop->pref === '大分県') selected @endif>大分県</option>
      <option value="宮崎県" @if($shop->pref === '宮崎県') selected @endif>宮崎県</option>
      <option value="鹿児島県" @if($shop->pref === '鹿児島県') selected @endif>鹿児島県</option>
      <option value="沖縄県" @if($shop->pref === '沖縄県') selected @endif>沖縄県</option>
    </select>
  </div>
  <div class="form-group">
    <label for="address1">
      市区町村
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="address1" name="address1" value="{{ $shop->address1 }}" required />
  </div>
  <div class="form-group">
    <label for="address2">
      番地建物名
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="address2" name="address2" value="{{ $shop->address2 }}" required />
  </div>
  <div class="form-group">
    <label for="access">アクセス</label>
    <textarea name="access" class="form-control" id="access" rows="5">{{ $shop->access }}</textarea>
  </div>
  <div class="form-group">
    <label for="googlemap_url">GoogleMapURL</label>
    <input type="url" class="form-control" id="googlemap_url" name="googlemap_url" value="{{ $shop->googlemap_url }}" />
  </div>
  <h3 class="font-weight-bold h5 mb-3 mt-4">3. お支払い方法</h3>
  <div class="form-group">
    <label for="payment">
      対応決済方法
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    @php
    $payment = explode(',', $shop->payment);
    @endphp
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="payment1" name="payment1" @if ($payment != null && in_array("1", $payment))checked @endif />
      <label class="form-check-label text-body" for="payment1">オンライン決済</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="2" id="payment2" name="payment2" @if ($payment != null && in_array("2", $payment))checked @endif />
      <label class="form-check-label text-body" for="payment2">店頭でお支払い</label>
    </div>
  </div>
  <h3 class="font-weight-bold h5 mb-3 mt-4">4. その他</h3>
  <div class="form-group">
    <label for="parking">駐車場について</label>
    <input type="text" class="form-control" id="parking" name="parking" value="{{ $shop->parking }}" />
  </div>

  <h3 class="font-weight-bold h5 mb-3 mt-4">5. 営業日時</h3>
  <div class="collapse-wrap">
    <div class="collapse-ttl" data-toggle="collapse" href="#settingTakeout">お持ち帰り</div>
    <div class="collapse" id="settingTakeout">
      <div class="form-group">
        <label for="takeout_preparation">
          ご注文受け付け時間
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="takeout_preparation" name="takeout_preparation" value="{{ $shop->takeout_preparation }}" required />
          <div class="input-group-prepend">
            <div class="input-group-text">分前</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        @foreach ($weeks as $id => $week)
        <div class="form-check flex-wrap">
          @php
          if($shop->{'takeout_'.$id} != null) {
              $l_start = explode(',', $shop->{'takeout_'.$id})[0];
              $l_end = explode(',', $shop->{'takeout_'.$id})[1];
              $d_start = explode(',', $shop->{'takeout_'.$id})[2];
              $d_end = explode(',', $shop->{'takeout_'.$id})[3];
          } else {
              $l_start = null;
              $l_end = null;
              $d_start = null;
              $d_end = null;
          }
          @endphp
          {{-- 曜日 --}}
          <input class="form-check-input" type="checkbox" name="takeout_{{ $id }}" value="1" id="takeout_{{ $id }}"@if($shop->{'takeout_'.$id} != null)checked @endif />
          <label class="form-check-label text-body mr-3" for="">{{ $week }}</label>
          <div class="d-md-none w-100 mt-2"></div>
          {{-- ランチタイム --}}
          <span class="mr-2">ランチ</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($l_start !== null && explode(':', $l_start)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($l_start !== null && explode(':', $l_start)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($l_end !== null && explode(':', $l_end)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($l_end !== null && explode(':', $l_end)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <div class="d-md-none w-100 mt-2"></div>
          {{-- ディナータイム --}}
          <span class="ml-md-3 mr-2">ディナー</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($d_start !== null && explode(':', $d_start)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($d_start !== null && explode(':', $d_start)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($d_end !== null && explode(':', $d_end)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($d_end !== null && explode(':', $d_end)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <!-- .collapse-wrap -->

  <input type="hidden" name="action" value="update">
  <input type="hidden" name="shops_id" value="{{ $shops_id }}">

  <div class="d-flex mt-4">
    <button type="submit" class="btn btn-success text-white px-5" id="btnEdit">確認する</button>
    <button type="submit" class="btn btn-danger text-white ml-auto" id="btnDelete">削除する</button>
  </div>
</form>

<script language="javascript" type="text/javascript">
  const btnPublic = document.getElementById('btnEdit');
  const btnDelete = document.getElementById('btnDelete');

  // 実行
  btnPublic.addEventListener('click', (e) => { // 公開
    e.preventDefault();
    document.edit.submit();
  });

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