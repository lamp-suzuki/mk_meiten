@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">トップ</h2>
<div class="d-lg-flex align-items-start">
  <div class="content w-100">
    <div class="content-head">
      <h3>
        <i data-feather="info"></i>
        <span>TakeEatsからのお知らせ</span>
      </h3>
    </div>
    <div class="content-body">
      @php
      $url = 'https://take-eats.jp/wp-json/wp/v2/systeminfo?per_page=1';
      $json = mb_convert_encoding(file_get_contents($url), 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
      $arr = json_decode($json,true)[0];
      $title = $arr['title']['rendered'];
      $date = date('Y-m-d', strtotime($arr['date']));
      $link = $arr['link'];
      @endphp
      <a class="text-body" href="{{ $link }}" target="_blank">
        <span class="d-block text-dark">{{ $date }}</span>
        <span class="d-block">{{ $title }}</span>
      </a>
    </div>
  </div>
  <!-- .content -->
  {{-- <div class="content">
    <div class="content-head">
      <h3>
        <i data-feather="info"></i>
        <span>ご注文受け付け設定</span>
      </h3>
    </div>
    <div class="content-body">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="shop_close" value="1">
        <label class="custom-control-label" for="shop_close">一時的にご注文を受け付けない</label>
      </div>
    </div>
  </div> --}}
  <!-- .content -->
  <div class="content sales">
    <div class="content-head">
      <h3 class="text-center font-weight-bold">
        <span>本日の売上</span>
      </h3>
    </div>
    <div class="content-body">
      <p class="price">
        <span class="number">{{ number_format($today_earnings) }}</span>
        <span class="compa">
          前日比
          @if ($comparison > 0)
          <span class="text-success">{{ $comparison }}%</span>
          @else
          <span class="text-danger">{{ $comparison }}%</span>
          @endif
        </span>
      </p>
    </div>
  </div>
  <!-- .content -->
  <div class="content">
    <div class="content-head">
      <h3>
        <i data-feather="clipboard"></i>
        <span>最新注文</span>
        <span class="badge badge-pill badge-secondary">{{ count($orders) }}</span>
      </h3>
      <a class="link" href="{{ route('manage.order.index', ['account' => $sub_domain]) }}">一覧へ</a>
    </div>
    <div class="content-body p-0">
      <div class="order-list">
        @foreach ($orders as $order)
        <a class="order-item" href="{{ route('manage.order.detail', ['account' => $sub_domain, 'id' => $order->id]) }}">
          @if ($order->cancel == 1)
          <span class="cats bg-danger">キャンセル済</span>
          @endif
          <span class="cats @if($order->service == '店舗受け取り') takeout @elseif($order->service == 'デリバリー') delivery @else ec @endif">{{ $order->service }}</span>
          <p class="name">{{ $order->furigana }}</p>
          <p class="date">{{ $order->created_at }}</p>
        </a>
        @endforeach
      </div>
      <!-- .order-list -->
    </div>
    <!-- .content-body -->
  </div>
  <!-- .content -->
</div>
<!-- .d-lg-flex -->
@endsection