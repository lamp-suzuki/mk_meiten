@extends('layouts.shop.app')

@section('page_title', 'ご注文を受け付けました！')

@section('content')
<div class="thanks py-5">
  <div class="container">
    <h2>
      <i data-feather="check-square" width="36" height="36"></i>
      <span>ご注文を受け付けました！</span>
    </h2>
    {{-- <p class="text-center font-weight-bold mt-3">
      注文番号は
      <span class="text-primary">{{ $order_id }}</span>
      です。
    </p> --}}
    <div class="thanks-menu">
      @php
      $counts = 0;
      @endphp
      @foreach ($thumbnails as $thum)
      @if ($thum !== null)
      <div>
        <img src="{{ url($thum) }}" />
      </div>
      @php
      ++$counts;
      @endphp
      @endif
      @php
      if ($counts > 2) {
          break;
      }
      @endphp
      @endforeach
    </div>
    <p class="text-center">
      ご注文ありがとうございます！
      <br />
      ご入力いただいたメールアドレス宛に
      <br />
      ご注文内容の詳細をお送りいたしました。
    </p>
    {{-- <p class="text-center">
      ご注文内容は
      <a href="./past-orders.html">注文履歴</a>
      よりご確認下さい。
    </p> --}}
    <hr />
    <div class="thanks-date form-group">
      <label for="" class="small d-block">お受け取り希望日時</label>
      <p class="mb-0 font-weight-bold text-primary">{{ $date_time }}</p>
    </div>
    <div class="cart__amount">
      <table class="w-100 table table-borderless">
        <tfoot>
          <tr>
            <th>ご注文金額</th>
            <td>¥ {{ number_format($total_amount) }}</td>
          </tr>
          @if($get_point != 0)
          <tr class="small">
            <th>獲得ポイント</th>
            <td>{{ $get_point }}pt</td>
          </tr>
          @endif
        </tfoot>
      </table>
    </div>
  </div>
  @if($service == 'takeout')
  <div class="ttl-horizon"></div>
  <div class="container mb-3">
    <div class="embed-responsive embed-responsive-16by9">
      <iframe class="embed-responsive-item"
        src="https://maps.google.co.jp/maps?output=embed&q={{ $shop_info->address1 }} {{ $shop_info->address2 }}"></iframe>
    </div>
  </div>
  @if ($shop_info->googlemap_url !== null)
  <div class="border-top py-3 mb-3">
    <div class="container">
      <p class="m-0">
        <a href="{{ $shop_info->googlemap_url }}" target="_blank">
          <i data-feather="map-pin" class="mr-1"></i>
          <span class="text-body">GoogleMapをみる</span>
        </a>
      </p>
    </div>
  </div>
  @endif
  <div class="border-top border-bottom py-3">
    <div class="container">
      <p class="m-0">
        <a href="{{ route('shop.shopinfo', ['account' => $sub_domain, 'id' => $shop_info->id]) }}">
          <i data-feather="info" class="mr-1"></i>
          <span class="text-body">店舗情報をみる</span>
        </a>
      </p>
    </div>
  </div>
  @endif
</div>
@endsection