@extends('layouts.shop.app')

@section('page_title', 'カート')

@section('content')
<div class="history-back d-md-none">
  <div class="container">
    <a href="{{ route('shop.home', ['account' => $sub_domain]) }}">
      <i data-feather="chevron-left"></i>
      <span>メニューに戻る</span>
    </a>
  </div>
</div>

<section class="mv">
  <div class="container">
    <h2>カート内容</h2>
  </div>
</section>
<!-- .mv -->

<form class="pc-two" action="{{ route('shop.order', ['account' => $sub_domain]) }}" method="POST" name="nextform" id="cartform">
  <div>
    @csrf
    <div class="cart__list pb-4 pt-md-4">
      <div class="container">
        @if (session()->has('cart.vali'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          選択サービス対象外の商品がカート内にあります。<br><small>「{{ session('cart.vali_product') }}」</small>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if (session()->has('cart.valistock'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          在庫切れの商品がございます。<br><small>「{{ session('cart.valistock_product') }}」</small>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if (!is_array(session('cart.products')) || $items_count < 2)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span>商品が2個以上でないとご注文できません。</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger fade show" role="alert">
          未入力または入力に誤りがござます。
        </div>
        @endif
        <ol>
          @foreach ($products as $index => $product)
          <li>
            @if (isset($product['data']->thumbnail_1))
            <div class="thumbnail">
              <img src="{{ url($product['data']->thumbnail_1) }}" alt="{{ $product['data']->name }}" />
            </div>
            @endif
            <div class="info">
              <p class="name">{{ $product['data']->name }}</p>
              @if (isset($options[$index]))
              <span class="options">
                @foreach ($options[$index]['name'] as $opt)
                <small class="text-muted mr-1">{{ $opt }}</small>
                @endforeach
              </span>
              @endif
              @php
              if (isset($options[$index])) {
                $opt_price = $options[$index]['price'];
              } else {
                $opt_price = 0;
              }
              @endphp
              <p class="price">{{ number_format(($product['data']->price + $opt_price)*session('cart.products.'.$index.'.quantity')) }}</p>
              <select class="form-control form-control-sm w-auto js-cart-quantity" name="counts" data-quantity="{{ session('cart.products.'.$index.'.quantity') }}" data-index="{{ $index }}" data-price="{{ $product['data']->price + $opt_price }}">
                @for ($i = 1; $i <= $product['stock']; $i++)
                <option value="{{ $i }}"@if($i==session('cart.products.'.$index.'.quantity')) selected @endif>{{ $i }}</option>
                @php
                if ($i === 50) {
                    break;
                }
                @endphp
                @endfor
              </select>
            </div>
            <div class="delete">
              <button class="btn btn-sm btn-primary btn-cartdelete" type="button" data-id="{{ $index }}">削除</button>
            </div>
          </li>
          @endforeach
        </ol>
      </div>
    </div>
    <!-- .cart__list -->
    <div class="cart__delidate pb-4">
      <h3 class="ttl-horizon">
        <span class="d-block container">お受け取りについて</span>
      </h3>
      <div class="container">
        <div class="form-group">
          <label for="changeReceive" class="small d-block">お受け取り方法</label>
          <select id="changeReceive" class="form-control js-vali" name="changeReceive" readonly disabled>
            <option value="delivery" @if(session('receipt.service')==='delivery') selected @endif>デリバリー(MKタク配)</option>
          </select>
        </div>
        <div class="form-group">
          <label for="changeDeliveryDate" class="small d-block">お受け取り日時</label>
          <select id="deliveryDate" class="form-control js-vali" name="delivery_date" readonly disabled>
            @for ($i = 0; $i <= 14; $i++)
            <option value="{{ date('Y-m-d', strtotime('+'.$i.' day')) }}" @if(session('receipt.date')===date('Y-m-d', strtotime('+'.$i.' day'))) selected @endif>{{ date('Y年n月j日', strtotime('+'.$i.' day')) }}@if($i == 0)（本日）@elseif($i == 1)（明日）@endif</option>
            @endfor
          </select>
        </div>
        <div class="form-group">
          <select id="changedeliveryTime" class="form-control js-vali" name="delivery_time" readonly disabled>
            <option value="{{ session('receipt.time') }}">{{ session('receipt.time') }}</option>
          </select>
        </div>
        @if(session('receipt.service')==='takeout')
        <div class="form-group">
          <label for="changeDeliveryDate" class="small d-block">お受け取り店舗</label>
          <select id="changeDeliveryShop" class="form-control js-vali" name="delivery_shop" readonly disabled>
            <option>店舗を選択</option>
            @foreach ($shops as $shop)
            <option value="{{ $shop->id }}:{{ $shop->name }}"@if(session('receipt.shop_id') !== null && session('receipt.shop_id') == $shop->id) selected @endif>{{ $shop->name }}</option>
            @endforeach
          </select>
        </div>
        @endif
        @if(session('receipt.service')=='ec')
        <small class="form-text text-muted d-block">※ご選択いただいた時間帯にご在宅願います。
          <br>※配達状況においてご希望に添えない場合がございます。予めご了承くださいませ。</small>
        @endif
      </div>
    </div>
    {{-- cart__option --}}
    <div class="pb-4">
      <h3 class="ttl-horizon">
        <span class="d-block container">その他のご要望</span>
      </h3>
      <div class="container">
        <textarea name="other_content" class="form-control" rows="6" maxlength="250"
          placeholder="">@if(session('form_cart.other_content') !== null){!! e(session('form_cart.other_content')) !!}@endif</textarea>
      </div>
    </div>
  </div>
  <div class="seconds">
    <div class="cart__amount pb-4">
      <h3 class="ttl-horizon">
        <span class="d-block container">合計金額</span>
      </h3>
      <div class="container">
        <table class="w-100 table table-borderless mb-0">
          <tbody>
            <tr>
              <th>小計</th>
              <td>¥ {{ number_format(session('cart.amount')) }}</td>
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
              <td>¥ <span class="js-cart-total">{{ number_format(session('cart.amount') + session('cart.shipping')) }}</span></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="py-4 bg-light">
      <div class="container">
        <div class="d-flex justify-content-center form-btns">
          <a class="btn btn-lg bg-white btn-back mr-2" href="{{ route('shop.home', ['account' => $sub_domain]) }}">戻る</a>
          <button class="btn btn-lg btn-primary" type="submit"@if (session()->has('cart.vali') || $items_count < 2) disabled @endif>注文へ進む</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form id="cartdelete" action="{{ route('shop.cart.delete', ['account' => $sub_domain]) }}" method="POST">
  @csrf
  <input type="hidden" name="product_id" value="">
</form>
@endsection