@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">運営者情報に関する設定</h2>

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

<form class="mt-4" action="{{ route('manage.setting.transaction.update', ['account' => $sub_domain]) }}" method="post">
  @csrf
  <div class="form-group">
    <label for="name">事業者の氏名<span class="badge badge-warning text-white ml-1">必須</span></label>
    <input type="text" name="name" class="form-control" id="name" value="{{ isset($transactions->name) ? $transactions->name : '' }}" required>
  </div>
  <div class="form-group">
    <label for="zipcode">
      郵便番号
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <div class="input-group w-50 justify-content-start">
      <div class="input-group-prepend">
        <div class="input-group-text">〒</div>
      </div>
      <input type="text" maxlength="8" class="form-control w-50" id="zipcode" name="zipcode" value="{{ isset($transactions->zipcode) ? $transactions->zipcode : '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label for="pref">
      都道府県
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <select name="pref" class="form-control w-auto" id="pref" name="pref" required>
      <option value="">都道府県</option>
      <option value="北海道"@if(isset($transactions->pref) && $transactions->pref == '北海道') selected @endif>北海道</option>
      <option value="青森県"@if(isset($transactions->pref) && $transactions->pref == '青森県') selected @endif>青森県</option>
      <option value="岩手県"@if(isset($transactions->pref) && $transactions->pref == '岩手県') selected @endif>岩手県</option>
      <option value="宮城県"@if(isset($transactions->pref) && $transactions->pref == '宮城県') selected @endif>宮城県</option>
      <option value="秋田県"@if(isset($transactions->pref) && $transactions->pref == '秋田県') selected @endif>秋田県</option>
      <option value="山形県"@if(isset($transactions->pref) && $transactions->pref == '山形県') selected @endif>山形県</option>
      <option value="福島県"@if(isset($transactions->pref) && $transactions->pref == '福島県') selected @endif>福島県</option>
      <option value="茨城県"@if(isset($transactions->pref) && $transactions->pref == '茨城県') selected @endif>茨城県</option>
      <option value="栃木県"@if(isset($transactions->pref) && $transactions->pref == '栃木県') selected @endif>栃木県</option>
      <option value="群馬県"@if(isset($transactions->pref) && $transactions->pref == '群馬県') selected @endif>群馬県</option>
      <option value="埼玉県"@if(isset($transactions->pref) && $transactions->pref == '埼玉県') selected @endif>埼玉県</option>
      <option value="千葉県"@if(isset($transactions->pref) && $transactions->pref == '千葉県') selected @endif>千葉県</option>
      <option value="東京都"@if(isset($transactions->pref) && $transactions->pref == '東京都') selected @endif>東京都</option>
      <option value="神奈川県"@if(isset($transactions->pref) && $transactions->pref == '神奈川県') selected @endif>神奈川県</option>
      <option value="新潟県"@if(isset($transactions->pref) && $transactions->pref == '新潟県') selected @endif>新潟県</option>
      <option value="富山県"@if(isset($transactions->pref) && $transactions->pref == '富山県') selected @endif>富山県</option>
      <option value="石川県"@if(isset($transactions->pref) && $transactions->pref == '石川県') selected @endif>石川県</option>
      <option value="福井県"@if(isset($transactions->pref) && $transactions->pref == '福井県') selected @endif>福井県</option>
      <option value="山梨県"@if(isset($transactions->pref) && $transactions->pref == '山梨県') selected @endif>山梨県</option>
      <option value="長野県"@if(isset($transactions->pref) && $transactions->pref == '長野県') selected @endif>長野県</option>
      <option value="岐阜県"@if(isset($transactions->pref) && $transactions->pref == '岐阜県') selected @endif>岐阜県</option>
      <option value="静岡県"@if(isset($transactions->pref) && $transactions->pref == '静岡県') selected @endif>静岡県</option>
      <option value="愛知県"@if(isset($transactions->pref) && $transactions->pref == '愛知県') selected @endif>愛知県</option>
      <option value="三重県"@if(isset($transactions->pref) && $transactions->pref == '三重県') selected @endif>三重県</option>
      <option value="滋賀県"@if(isset($transactions->pref) && $transactions->pref == '滋賀県') selected @endif>滋賀県</option>
      <option value="京都府"@if(isset($transactions->pref) && $transactions->pref == '京都府') selected @endif>京都府</option>
      <option value="大阪府"@if(isset($transactions->pref) && $transactions->pref == '大阪府') selected @endif>大阪府</option>
      <option value="兵庫県"@if(isset($transactions->pref) && $transactions->pref == '兵庫県') selected @endif>兵庫県</option>
      <option value="奈良県"@if(isset($transactions->pref) && $transactions->pref == '奈良県') selected @endif>奈良県</option>
      <option value="和歌山県"@if(isset($transactions->pref) && $transactions->pref == '和歌山県') selected @endif>和歌山県</option>
      <option value="鳥取県"@if(isset($transactions->pref) && $transactions->pref == '鳥取県') selected @endif>鳥取県</option>
      <option value="島根県"@if(isset($transactions->pref) && $transactions->pref == '島根県') selected @endif>島根県</option>
      <option value="岡山県"@if(isset($transactions->pref) && $transactions->pref == '岡山県') selected @endif>岡山県</option>
      <option value="広島県"@if(isset($transactions->pref) && $transactions->pref == '広島県') selected @endif>広島県</option>
      <option value="山口県"@if(isset($transactions->pref) && $transactions->pref == '山口県') selected @endif>山口県</option>
      <option value="徳島県"@if(isset($transactions->pref) && $transactions->pref == '徳島県') selected @endif>徳島県</option>
      <option value="香川県"@if(isset($transactions->pref) && $transactions->pref == '香川県') selected @endif>香川県</option>
      <option value="愛媛県"@if(isset($transactions->pref) && $transactions->pref == '愛媛県') selected @endif>愛媛県</option>
      <option value="高知県"@if(isset($transactions->pref) && $transactions->pref == '高知県') selected @endif>高知県</option>
      <option value="福岡県"@if(isset($transactions->pref) && $transactions->pref == '福岡県') selected @endif>福岡県</option>
      <option value="佐賀県"@if(isset($transactions->pref) && $transactions->pref == '佐賀県') selected @endif>佐賀県</option>
      <option value="長崎県"@if(isset($transactions->pref) && $transactions->pref == '長崎県') selected @endif>長崎県</option>
      <option value="熊本県"@if(isset($transactions->pref) && $transactions->pref == '熊本県') selected @endif>熊本県</option>
      <option value="大分県"@if(isset($transactions->pref) && $transactions->pref == '大分県') selected @endif>大分県</option>
      <option value="宮崎県"@if(isset($transactions->pref) && $transactions->pref == '宮崎県') selected @endif>宮崎県</option>
      <option value="鹿児島県"@if(isset($transactions->pref) && $transactions->pref == '鹿児島県') selected @endif>鹿児島県</option>
      <option value="沖縄県"@if(isset($transactions->pref) && $transactions->pref == '沖縄県') selected @endif>沖縄県</option>
    </select>
  </div>
  <div class="form-group">
    <label for="address1">
      市区町村
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="address1" name="address1" value="{{ isset($transactions->address1) ? $transactions->address1 : '' }}" required>
  </div>
  <div class="form-group">
    <label for="address2">
      番地建物名
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="text" class="form-control" id="address2" name="address2" value="{{ isset($transactions->address2) ? $transactions->address2 : '' }}" required>
  </div>
  <div class="form-group">
    <label for="tel">
      事業者の連絡先(電話番号)
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <input type="tel" class="form-control" id="tel" name="tel" value="{{ isset($transactions->tel) ? $transactions->tel : '' }}" required>
  </div>
  <div class="form-group">
    <label for="business">
      その他(営業時間・定休日等)
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <textarea class="form-control" id="business" name="business" cols="30" rows="5">@if(isset($transactions->business)){!! e($transactions->business) !!}@endif</textarea>
  </div>
  <div class="form-group">
    <label for="selling_price">
      販売価格について
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <textarea class="form-control" id="selling_price" name="selling_price" cols="30" rows="5">@if(isset($transactions->selling_price)){!! e($transactions->selling_price) !!}@endif</textarea>
  </div>
  <div class="form-group">
    <label for="payment_method">
      支払方法と時期
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <textarea class="form-control" id="payment_method" name="payment_method" cols="30" rows="5">@if(isset($transactions->payment_method)){!! e($transactions->payment_method) !!}@endif</textarea>
  </div>
  <div class="form-group">
    <label for="delivery_time">
      商品の引渡時期
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <textarea class="form-control" id="delivery_time" name="delivery_time" cols="30" rows="5">@if(isset($transactions->delivery_time)){!! e($transactions->delivery_time) !!}@endif</textarea>
  </div>
  <div class="form-group">
    <label for="returns">
      返品についての特約に関する事項
      <span class="badge badge-warning text-white ml-1">必須</span>
    </label>
    <textarea class="form-control" id="returns" name="returns" cols="30" rows="5">@if(isset($transactions->returns)){!! e($transactions->returns) !!}@endif</textarea>
  </div>
  <div class="mt-4">
    <button type="submit" class="btn btn-success px-5 text-white">保存する</button>
  </div>
</form>
@endsection