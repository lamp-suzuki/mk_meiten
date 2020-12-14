@extends('layouts.shop.app')

@section('page_title', '注文履歴')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>注文履歴</h2>
  </div>
</section>
<div class="py-5">
  <div class="container">
    <p class="text-right">{{ count($orders) }}件</p>
  </div>
  <div class="orders">
    @foreach ($orders as $order)
    <div class="orders-item">
      <div class="orders-head">
        <table class="table table-sm table-borderless m-0">
          <thead>
            <tr>
              <th>注文番号</th>
              <th>{{ $order['service'] }}注文</th>
            </tr>
          </thead>
          <tr>
            <td>{{ $order['id'] }}</td>
            <td>{{ $order['delivery_time'] }}</td>
          </tr>
        </table>
      </div>
      <div class="orders-body">
        <div class="orders-list">
          @foreach ($order['products'] as $item)
          <div class="orders-list-menu">
            <div class="thumbnail">
              <img src="{{ url('/') }}/{{ $item['thumbnail'] }}" alt="{{ $item['name'] }}" />
            </div>
            <p class="name">
              <span class="d-block">{{ $item['name'] }}</span>
              @foreach ($item['options'] as $opt)
              <small class="text-muted">{{ $opt['name'] }}</small>
              @endforeach
            </p>
            <div class="info">
              <span class="count">{{ $item['quantity'] }}個</span>
              <span class="price">{{ number_format($item['total_price']) }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="orders-foot cart__amount">
        <table class="w-100 table table-borderless">
          <tfoot>
            <tr>
              <th class="border-0">合計金額</th>
              <td class="border-0">¥ {{ number_format($order['total_amount']) }}</td>
            </tr>
          </tfoot>
        </table>
        <div class="mt-4 text-center">
          <form action="{{ route('member.again') }}" method="post">
            @csrf
            <input type="hidden" name="orders_id" value="{{ $order['id'] }}">
            <button class="btn btn-primary rounded-pill" type="submit">再注文する</button>
          </form>
        </div>
      </div>
    </div>
    <!-- .orders-item -->
    @endforeach
  </div>
  <!-- .orders -->
</div>
@endsection