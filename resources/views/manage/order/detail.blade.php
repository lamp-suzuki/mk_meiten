@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">注文詳細</h2>

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

<div class="mb-4">
  <h3 class="page-ttl-sub">基本情報</h3>
  <div class="order__detail w-100">
    <div class="order__detail-head">
      <span>{{ $order->created_at }}</span>
      <span>{{ $order->service }}</span>
    </div>
    <div class="order__detail-body">
      @if ($order->cancel == 1)
      <span class="badge-warning py-1 px-2 small d-inline-block mb-2">キャンセル済</span>
      @endif
      <p class="name">
        <span class="furi">{{ $order->furigana }}</span>
        <span>{{ $order->name }}</span>
      </p>
      <table class="table table-sm table-borderless w-auto">
        <tbody>
          <tr>
            <th class="text-nowrap">注文番号</th>
            <td>{{ $order->id }}</td>
          </tr>
          @if ($order->service == '店舗受け取り' || $order->service == 'お持ち帰り')
          <tr>
            <th class="text-nowrap">注文店舗</th>
            <td>{{ $shop->name }}</td>
          </tr>
          @endif
          <tr>
            <th class="text-nowrap">受け取り時間</th>
            <td>{{ $order->delivery_time }}</td>
          </tr>
          <tr>
            <th class="text-nowrap">お支払い方法</th>
            <td>
              @if ($order->payment_method == 0)
              クレジットカード決済
              @else
              店舗でお支払い
              @endif
            </td>
          </tr>
          <tr>
            <th class="text-nowrap">メールアドレス</th>
            <td>
              <a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
            </td>
          </tr>
          <tr>
            <th class="text-nowrap">電話番号</th>
            <td>
              <a href="tel:{{ $order->tel }}">{{ $order->tel }}</a>
            </td>
          </tr>
          @if ($order->zipcode !== null)
          <tr>
            <th class="text-nowrap">住所</th>
            <td>〒{{ $order->zipcode }}
              <br>{{ $order->pref }} {{ $order->address1 }}
              <br>{{ $order->address2 }}</td>
          </tr>
          @endif
          @if(isset($order->memo) && $order->memo != null && $order->memo != '')
          <tr>
            <th class="text-nowrap">その他ご要望</th>
            <td>{{ $order->memo }}</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
  <!-- .order__detail -->
</div>
<div class="mb-4">
  <h3 class="page-ttl-sub">注文内容</h3>
  <div class="order-menus">
    <div class="order-menus-list">
      @php
      $produc_amount = 0;
      @endphp
      @foreach ($products as $product)
      @php
      $produc_amount += $product['amount'];
      @endphp
      <div class="order-menus-item">
        @if ($product['thumbnail'] != null)
        <div class="thumbnail">
          <img src="{{ url('/') }}/{{ $product['thumbnail'] }}" alt="{{ $product['name'] }}" width="150" />
        </div>
        @endif
        <div class="info">
          <p class="name">
            <span class="d-block">{{ $product['name'] }}</span>
            @foreach ($product['options'] as $opt)
            <small class="text-muted mr-1">{{ $opt['name'] }}</small>
            @endforeach
          </p>
          <p class="price">{{ number_format($product['amount']) }}</p>
        </div>
        <div class="count ml-auto">x {{ $product['quantity'] }}</div>
      </div>
      @endforeach
    </div>
    <div class="order-menus-price pb-0">
      <span class="ttl font-weight-normal">送料</span>
      <span class="price">{{ number_format($order->shipping) }}</span>
    </div>
    <div class="order-menus-price">
      <span class="ttl">合計</span>
      <span class="price">{{ number_format($order->total_amount) }}</span>
    </div>
  </div>
</div>

@if ($order->cancel == 0)
<form action="{{ route('manage.order.cancel', ['account' => $sub_domain, 'id' => $order->id]) }}" method="POST" class="mt-3 text-right" onsubmit="return check();">
  @csrf
  <input type="hidden" name="oreder_id" value="{{ $order->id }}">
  <button type="submit" class="btn btn-warning text-white">注文をキャンセルする</button>
</form>

<script>
  function check() {
  if(window.confirm('一度キャンセルすると元に戻すことはできません。本当にキャンセルしてもよろしいですか？')) {
    return true;
  } else {
    return false;
  }
}
</script>
@endif
@endsection