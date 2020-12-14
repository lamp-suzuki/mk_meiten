@extends('layouts.manage.app')

@php
$weeks = ['sun' => '日','mon' => '月','tue' => '火','wed' => '水','thu' => '木','fri' => '金','sat' => '土'];
@endphp

@section('content')
<h2 class="page-ttl">店舗の追加</h2>
<form action="{{ route('manage.shop.confirm', ['account' => $sub_domain]) }}" method="post">
  @csrf
  <h3 class="font-weight-bold h5 mb-3">1. 基本情報</h3>
  <div class="form-group">
    <label for="name">
      店舗名
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required />
  </div>
  <div class="form-group">
    <label for="tel">
      電話番号
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="tel" class="form-control" id="tel" name="tel" value="{{ old('tel') }}" required />
  </div>
  <div class="form-group">
    <label for="fax">FAX</label>
    <input type="tel" class="form-control" id="fax" name="fax" value="{{ old('fax') }}" />
  </div>
  <div class="form-group">
    <label for="email">
      メールアドレス
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required />
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
      <input type="text" maxlength="8" class="form-control w-50" id="zipcode" name="zipcode" value="{{ old('zipcode') }}" required />
    </div>
  </div>
  <div class="form-group">
    <label for="pref">
      都道府県
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <select name="pref" class="form-control w-auto" id="pref" name="pref" required>
      <option value="" selected>都道府県</option>
      <option value="北海道">北海道</option>
      <option value="青森県">青森県</option>
      <option value="岩手県">岩手県</option>
      <option value="宮城県">宮城県</option>
      <option value="秋田県">秋田県</option>
      <option value="山形県">山形県</option>
      <option value="福島県">福島県</option>
      <option value="茨城県">茨城県</option>
      <option value="栃木県">栃木県</option>
      <option value="群馬県">群馬県</option>
      <option value="埼玉県">埼玉県</option>
      <option value="千葉県">千葉県</option>
      <option value="東京都">東京都</option>
      <option value="神奈川県">神奈川県</option>
      <option value="新潟県">新潟県</option>
      <option value="富山県">富山県</option>
      <option value="石川県">石川県</option>
      <option value="福井県">福井県</option>
      <option value="山梨県">山梨県</option>
      <option value="長野県">長野県</option>
      <option value="岐阜県">岐阜県</option>
      <option value="静岡県">静岡県</option>
      <option value="愛知県">愛知県</option>
      <option value="三重県">三重県</option>
      <option value="滋賀県">滋賀県</option>
      <option value="京都府">京都府</option>
      <option value="大阪府">大阪府</option>
      <option value="兵庫県">兵庫県</option>
      <option value="奈良県">奈良県</option>
      <option value="和歌山県">和歌山県</option>
      <option value="鳥取県">鳥取県</option>
      <option value="島根県">島根県</option>
      <option value="岡山県">岡山県</option>
      <option value="広島県">広島県</option>
      <option value="山口県">山口県</option>
      <option value="徳島県">徳島県</option>
      <option value="香川県">香川県</option>
      <option value="愛媛県">愛媛県</option>
      <option value="高知県">高知県</option>
      <option value="福岡県">福岡県</option>
      <option value="佐賀県">佐賀県</option>
      <option value="長崎県">長崎県</option>
      <option value="熊本県">熊本県</option>
      <option value="大分県">大分県</option>
      <option value="宮崎県">宮崎県</option>
      <option value="鹿児島県">鹿児島県</option>
      <option value="沖縄県">沖縄県</option>
    </select>
  </div>
  <div class="form-group">
    <label for="address1">
      市区町村
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="address1" name="address1" value="{{ old('address1') }}" required />
  </div>
  <div class="form-group">
    <label for="address2">
      番地建物名
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="address2" name="address2" value="{{ old('address2') }}" required />
  </div>
  <div class="form-group">
    <label for="access">アクセス</label>
    <textarea name="access" class="form-control" id="access" rows="5"></textarea>
  </div>
  <div class="form-group">
    <label for="googlemap_url">GoogleMapURL</label>
    <input type="url" class="form-control" id="googlemap_url" name="googlemap_url" />
  </div>
  <h3 class="font-weight-bold h5 mb-3 mt-4">3. お支払い方法</h3>
  <div class="form-group">
    <label for="payment">
      対応決済方法
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="payment1" name="payment1" checked />
      <label class="form-check-label text-body" for="payment1">オンライン決済</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="2" id="payment2" name="payment2" />
      <label class="form-check-label text-body" for="payment2">店頭でお支払い</label>
    </div>
  </div>
  <h3 class="font-weight-bold h5 mb-3 mt-4">4. その他</h3>
  <div class="form-group">
    <label for="parking">駐車場について</label>
    <input type="text" class="form-control" id="parking" name="parking" />
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
          <input type="number" min="0" class="form-control" id="takeout_preparation" name="takeout_preparation" value="" required />
          <div class="input-group-prepend">
            <div class="input-group-text">分前</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        @foreach ($weeks as $id => $week)
        <div class="form-check flex-wrap">
          {{-- 曜日 --}}
          <input class="form-check-input" type="checkbox" name="takeout_{{ $id }}" value="1" id="takeout_{{ $id }}" />
          <label class="form-check-label text-body mr-3" for="">{{ $week }}</label>
          <div class="d-md-none w-100 mt-2"></div>
          {{-- ランチタイム --}}
          <span class="mr-2">ランチ</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_lunch_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <div class="d-md-none w-100 mt-2"></div>
          {{-- ディナータイム --}}
          <span class="ml-md-3 mr-2">ディナー</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="takeout_dinner_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <!-- .collapse-wrap -->
  {{-- <div class="collapse-wrap">
    <div class="collapse-ttl" data-toggle="collapse" href="#settingDelivery">デリバリー</div>
    <div class="collapse" id="settingDelivery">
      <div class="form-group">
        <label for="delivery_preparation">
          ご注文受け付け時間
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="delivery_preparation" name="delivery_preparation" value="" required />
          <div class="input-group-prepend">
            <div class="input-group-text">分前</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        @foreach ($weeks as $id => $week)
        <div class="form-check flex-wrap">
          <input class="form-check-input" type="checkbox" name="delivery_{{ $id }}" value="1" id="delivery_{{ $id }}" />
          <label class="form-check-label text-body mr-3" for="">{{ $week }}</label>
          <div class="d-md-none w-100 mt-2"></div>
          <span class="mr-2">ランチ</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <div class="d-md-none w-100 mt-2"></div>
          <span class="ml-md-3 mr-2">ディナー</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
        </div>
        @endforeach
      </div>
    </div>
  </div> --}}
  <!-- .collapse-wrap -->

  <div class="mt-5 text-center">
    <button type="submit" class="btn btn-success text-white px-5">確認する</button>
  </div>
</form>

<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script>
$('#zipcode').jpostal({
  postcode : [
    '#zipcode' // 郵便番号のid名
  ],
  address : {
    '#pref' : '%3', // %3 = 都道府県
    '#address1' : '%4%5', // %4 = 市区町村, %5 = 町名
  }
});
</script>
@endsection