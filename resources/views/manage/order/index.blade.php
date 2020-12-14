@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">注文管理</h2>
<form class="form-inline border-top border-bottom py-3" action="{{ route('manage.order.index', ['account' => $sub_domain]) }}" method="POST">
  @csrf
  <select class="custom-select border-0" name="period">
    <option value="all"@if(isset($request->period) && $request->period == 'all') selected @endif>全期間</option>
    <option value="lastday"@if(isset($request->period) && $request->period == 'lastday') selected @endif>昨日</option>
    <option value="today"@if(isset($request->period) && $request->period == 'today') selected @endif>今日</option>
    <option value="thismonth"@if(isset($request->period) && $request->period == 'thismonth') selected @endif>今月</option>
    <option value="lastmonth"@if(isset($request->period) && $request->period == 'lastmonth') selected @endif>先月</option>
    {{-- 配達 --}}
    <option value="deli-today"@if(isset($request->period) && $request->period == 'deli-lastday') selected @endif>昨日（配達）</option>
    <option value="deli-today"@if(isset($request->period) && $request->period == 'deli-today') selected @endif>今日（配達）</option>
    <option value="deli-tomorrow"@if(isset($request->period) && $request->period == 'deli-tomorrow') selected @endif>明日（配達）</option>
    <option value="deli-after-tomorrow"@if(isset($request->period) && $request->period == 'deli-after-tomorrow') selected @endif>明後日（配達）</option>
  </select>
  <input type="search" class="form-control mx-lg-3 my-lg-0 my-2" name="ketwords" placeholder="キーワードで検索" value="@if(isset($request->ketwords)){{ $request->ketwords }}@endif" />
  <button type="submit" class="btn btn-primary">
    <i data-feather="search"></i>
    <span>絞り込み</span>
  </button>
</form>
<div class="my-4 d-flex justify-content-between">
  <form action="{{ route('manage.order.download', ['account' => $sub_domain]) }}" method="POST">
    @csrf
    <input type="hidden" name="period" value="@if(isset($request->period)){{ $request->period }}@endif">
    <input type="hidden" name="ketwords" value="@if(isset($request->ketwords)){{ $request->ketwords }}@endif">
    <button type="submit" class="btn btn-light rounded-pill px-3">CSVダウンロード</button>
  </form>
</div>
<div class="order-list">
  @foreach ($orders as $order)
  <a class="order-item" href="{{ route('manage.order.detail', ['account' => $sub_domain, 'id' => $order->id]) }}" @if ($order->cancel == 1)style="opacity:0.7"@endif>
    @if ($order->cancel == 1)
    <span class="cats bg-danger">キャンセル済</span>
    @endif
    <span class="cats @if($order->service == '店舗受け取り') takeout @elseif($order->service == 'デリバリー') delivery @else ec @endif">{{ $order->service }}</span>
    <p class="name">{{ $order->furigana }}</p>
    <p class="date">{{ $order->created_at }}</p>
  </a>
  @endforeach
  @if (count($orders) == 0)
  <p class="mb-0">注文が見つかりません。</p>
  @endif
  <div class="text-center mt-4">
    {{ $orders->onEachSide(0)->links() }}
  </div>
</div>
<!-- .order-list -->

{{-- ページリロード 30秒 --}}
<script>
  const timer = 300000;
  window.addEventListener('load', function() {
    setInterval('location.reload()', timer);
  });
</script>
@endsection