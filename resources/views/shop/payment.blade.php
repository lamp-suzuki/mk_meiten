@extends('layouts.shop.app')

@section('page_title', 'お支払い情報入力')

@section('content')
<section class="mv">
  <div class="container">
    <h2>お支払い情報入力</h2>
  </div>
</section>
<div class="mv__step mb-md-5">
  <div class="container">
    <ol class="mv__step-count">
      <li class="visited"><em>情報入力</em></li>
      <li class="current"><em>お支払い</em></li>
      <li class=""><em>確認</em></li>
      <li class=""><em>完了</em></li>
    </ol>
  </div>
</div>

<form class="pc-two" action="{{ route('shop.confirm', ['account' => $sub_domain]) }}" method="POST">
  <div>
    @csrf
    <div class="py-4">
      <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger"><small>入力に誤りまたは未入力があります。</small></div>
        @endif
        <h3 class="form-ttl">お支払い情報</h3>
        <div class="form-group mb-0">
          <label class="small d-block form-must" for="">お支払い方法(選択)</label>
          <select class="form-control" id="pay" name="pay">
            <option value="">選択してください</option>
            <option value="0"@if(session('form_payment.pay')==='0') selected @endif>クレジットカード決済</option>
          </select>
          <script type="text/javascript" src="https://checkout.pay.jp/" class="payjp-button"
            data-key="{{ config('app.payjpkey_public') }}" data-submit-text="適用して閉じる" data-partial="true"></script>
        </div>
      </div>
    </div>
    <div class="py-4 d-none">
      <h3 class="ttl-horizon">
        <span class="d-block container">領収書について</span>
      </h3>
      <div class="container">
        <div class="form-group form-check mb-0">
          <input type="checkbox" class="form-check-input" id="receipt" name="set-receipt" value="1" />
          <label class="form-check-label" for="receipt">領収書をつける</label>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class="py-4 pt-md-0 pb-4 cart__amount">
      <h3 class="ttl-horizon">
        <span class="d-block container">合計金額</span>
      </h3>
      <div class="container">
        <table class="w-100 table table-borderless mb-0">
          <tbody>
            <tr>
              <th>小計</th>
              <td>¥ {{ number_format(session('cart.amount') - session('form_cart.okimochi')) }}</td>
            </tr>
            @if (session('receipt.service')!='takeout')
            <tr>
              <th>送料</th>
              <td>¥ {{ number_format(session('cart.shipping')) }}</td>
            </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>合計</th>
              <td>¥ {{ number_format(session('cart.amount') + session('cart.shipping')) }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="py-4 bg-light">
      <div class="container">
        <div class="d-flex justify-content-center form-btns">
          <a class="btn btn-lg bg-white btn-back mr-2" href="{{ route('shop.order', ['account' => $sub_domain]) }}">戻る</a>
          <button class="btn btn-lg btn-primary" type="submit">確認画面へ</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection