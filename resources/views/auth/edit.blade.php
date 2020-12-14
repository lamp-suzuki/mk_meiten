@extends('layouts.shop.app')

@section('page_title', '会員情報の確認・編集')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>会員情報の確認・編集</h2>
  </div>
</section>
<div class="py-5">
  <div class="container">
    <form action="{{ route('member.update') }}" method="post">
      @csrf
      @if ($errors->any())
      <div class="alert alert-danger"><small>入力に誤りまたは未入力があります。</small></div>
      @endif
      <h3 class="form-ttl">お客様情報</h3>
      <div class="form-group">
        <label class="small d-block form-must" for="">氏名</label>
        <div class="row">
          <div class="col">
            <input type="text" class="form-control" id="name1" name="name1" placeholder="姓"
              value="{{ explode(' ', Auth::user()->name)[0] }}" required />
          </div>
          <div class="col">
            <input type="text" class="form-control" id="name2" name="name2" placeholder="名"
              value="{{ explode(' ', Auth::user()->name)[1] }}" required />
          </div>
        </div>
      </div>
      <!-- .form-group -->
      <div class="form-group">
        <label class="small d-block form-must" for="">氏名（フリガナ）</label>
        <div class="row">
          <div class="col">
            <input type="text" class="form-control" id="furi1" name="furi1" placeholder="セイ"
              value="{{ explode(' ', Auth::user()->furigana)[0] }}" required />
          </div>
          <div class="col">
            <input type="text" class="form-control" id="furi2" name="furi2" placeholder="メイ"
              value="{{ explode(' ', Auth::user()->furigana)[1] }}" required />
          </div>
        </div>
      </div>
      <!-- .form-group -->
      <div class="form-group">
        <label class="small d-block form-must" for="">電話番号</label>
        <input type="tel" class="form-control" name="tel" value="{{ Auth::user()->tel }}" placeholder="000-0000-0000" />
      </div>
      <!-- .form-group -->
      <div class="form-group">
        <label class="small d-block form-must" for="">メールアドレス</label>
        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="" />
      </div>
      <!-- .form-group -->
      <div class="form-group">
        <label class="small d-block form-must" for="">メールアドレス（確認）</label>
        <input type="email" class="form-control" name="email_confirmation" value="" placeholder="" />
      </div>
      <!-- .form-group -->
      <h3 class="form-ttl mt-4">お届け先情報</h3>
      <div class="form-group">
        <label class="small d-block form-must" for="">郵便番号</label>
        <div class="input-group w-50">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-zipcode">〒</span>
          </div>
          <input type="text" maxlength="8" class="form-control" id="zipcode" name="zipcode"
            value="{{ Auth::user()->zipcode }}" placeholder="000-0000" aria-describedby="basic-zipcode" />
        </div>
      </div>
      <!-- .form-group -->
      <div class="form-group">
        <label class="small d-block form-must" for="pref">都道府県</label>
        <select name="pref" class="form-control w-auto" id="pref" name="pref" required>
          <option value="">---</option>
          <option value="北海道"@if(Auth::user()->pref=='北海道') selected @endif>北海道</option>
          <option value="青森県"@if(Auth::user()->pref=='青森県') selected @endif>青森県</option>
          <option value="岩手県"@if(Auth::user()->pref=='岩手県') selected @endif>岩手県</option>
          <option value="宮城県"@if(Auth::user()->pref=='宮城県') selected @endif>宮城県</option>
          <option value="秋田県"@if(Auth::user()->pref=='秋田県') selected @endif>秋田県</option>
          <option value="山形県"@if(Auth::user()->pref=='山形県') selected @endif>山形県</option>
          <option value="福島県"@if(Auth::user()->pref=='福島県') selected @endif>福島県</option>
          <option value="茨城県"@if(Auth::user()->pref=='茨城県') selected @endif>茨城県</option>
          <option value="栃木県"@if(Auth::user()->pref=='栃木県') selected @endif>栃木県</option>
          <option value="群馬県"@if(Auth::user()->pref=='群馬県') selected @endif>群馬県</option>
          <option value="埼玉県"@if(Auth::user()->pref=='埼玉県') selected @endif>埼玉県</option>
          <option value="千葉県"@if(Auth::user()->pref=='千葉県') selected @endif>千葉県</option>
          <option value="東京都"@if(Auth::user()->pref=='東京都') selected @endif>東京都</option>
          <option value="神奈川県"@if(Auth::user()->pref=='神奈川県') selected @endif>神奈川県</option>
          <option value="新潟県"@if(Auth::user()->pref=='新潟県') selected @endif>新潟県</option>
          <option value="富山県"@if(Auth::user()->pref=='富山県') selected @endif>富山県</option>
          <option value="石川県"@if(Auth::user()->pref=='石川県') selected @endif>石川県</option>
          <option value="福井県"@if(Auth::user()->pref=='福井県') selected @endif>福井県</option>
          <option value="山梨県"@if(Auth::user()->pref=='山梨県') selected @endif>山梨県</option>
          <option value="長野県"@if(Auth::user()->pref=='長野県') selected @endif>長野県</option>
          <option value="岐阜県"@if(Auth::user()->pref=='岐阜県') selected @endif>岐阜県</option>
          <option value="静岡県"@if(Auth::user()->pref=='静岡県') selected @endif>静岡県</option>
          <option value="愛知県"@if(Auth::user()->pref=='愛知県') selected @endif>愛知県</option>
          <option value="三重県"@if(Auth::user()->pref=='三重県') selected @endif>三重県</option>
          <option value="滋賀県"@if(Auth::user()->pref=='滋賀県') selected @endif>滋賀県</option>
          <option value="京都府"@if(Auth::user()->pref=='京都府') selected @endif>京都府</option>
          <option value="大阪府"@if(Auth::user()->pref=='大阪府') selected @endif>大阪府</option>
          <option value="兵庫県"@if(Auth::user()->pref=='兵庫県') selected @endif>兵庫県</option>
          <option value="奈良県"@if(Auth::user()->pref=='奈良県') selected @endif>奈良県</option>
          <option value="和歌山県"@if(Auth::user()->pref=='和歌山県') selected @endif>和歌山県</option>
          <option value="鳥取県"@if(Auth::user()->pref=='鳥取県') selected @endif>鳥取県</option>
          <option value="島根県"@if(Auth::user()->pref=='島根県') selected @endif>島根県</option>
          <option value="岡山県"@if(Auth::user()->pref=='岡山県') selected @endif>岡山県</option>
          <option value="広島県"@if(Auth::user()->pref=='広島県') selected @endif>広島県</option>
          <option value="山口県"@if(Auth::user()->pref=='山口県') selected @endif>山口県</option>
          <option value="徳島県"@if(Auth::user()->pref=='徳島県') selected @endif>徳島県</option>
          <option value="香川県"@if(Auth::user()->pref=='香川県') selected @endif>香川県</option>
          <option value="愛媛県"@if(Auth::user()->pref=='愛媛県') selected @endif>愛媛県</option>
          <option value="高知県"@if(Auth::user()->pref=='高知県') selected @endif>高知県</option>
          <option value="福岡県"@if(Auth::user()->pref=='福岡県') selected @endif>福岡県</option>
          <option value="佐賀県"@if(Auth::user()->pref=='佐賀県') selected @endif>佐賀県</option>
          <option value="長崎県"@if(Auth::user()->pref=='長崎県') selected @endif>長崎県</option>
          <option value="熊本県"@if(Auth::user()->pref=='熊本県') selected @endif>熊本県</option>
          <option value="大分県"@if(Auth::user()->pref=='大分県') selected @endif>大分県</option>
          <option value="宮崎県"@if(Auth::user()->pref=='宮崎県') selected @endif>宮崎県</option>
          <option value="鹿児島県"@if(Auth::user()->pref=='鹿児島県') selected @endif>鹿児島県</option>
          <option value="沖縄県"@if(Auth::user()->pref=='沖縄県') selected @endif>沖縄県</option>
        </select>
      </div>
      <!-- .form-group -->
      <div class="form-group">
        <label class="small d-block form-must" for="address1">市区町村</label>
        <input type="text" class="form-control" id="address1" name="address1" value="{{ Auth::user()->address1 }}" />
      </div>
      <!-- .form-group -->
      <div class="form-group mb-0">
        <label class="small d-block form-must" for="address2">番地 建物名</label>
        <input type="text" class="form-control" id="address2" name="address2" value="{{ Auth::user()->address2 }}" />
      </div>
      <!-- .form-group -->
      <div class="mt-4 text-center">
        <button type="submit" class="btn btn-primary px-5">更新する</button>
      </div>
    </form>
  </div>
</div>
@endsection