@extends('layouts.manage.app')

@section('content')

@php
$weeks = [
    'sun' => '日',
    'mon' => '月',
    'tue' => '火',
    'wed' => '水',
    'thu' => '木',
    'fri' => '金',
    'sat' => '土'
];
@endphp

<h2 class="page-ttl">設定</h2>

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

{{-- menu --}}
@include('manage.setting.menu')

<div class="collapse-wrap mt-4 d-none">
  <div class="collapse-ttl" data-toggle="collapse" href="#settingTakeout">お持ち帰り設定</div>
  <div class="collapse" id="settingTakeout">
    <form action="{{ route('manage.setting.service.takeout.update', ['account' => $sub_domain]) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="takeout_preparation">
          ご注文受け付け時間
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="takeout_preparation" name="takeout_preparation" value="{{ $manage->takeout_preparation }}" required />
          <div class="input-group-prepend">
            <div class="input-group-text">分前</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="">キャンセルについて</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="cancelTakeout" value="0" id="cancelTakeoutFalse"
            @if($manage->takeout_cancel == 0)checked @endif />
          <label class="form-check-label text-body" for="cancelTakeoutFalse">受け付けない</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="cancelTakeout" value="1" id="cancelTakeoutTrue"
            @if($manage->takeout_cancel == 1)checked @endif />
          <label class="form-check-label text-body" for="cancelTakeoutTrue">受け付ける</label>
        </div>
      </div>
      {{-- <div class="form-group">
        <label for="">キャンセル受付時間</label>
        <div class="form-inline">
          <span>お受取り時間の</span>
          <input type="number" name="" value="0" class="form-control p-2 mx-2 w-auto" min="0" max="9999" id="" />
          <span>分前まで</span>
        </div>
      </div> --}}
      <div class="mt-4 text-center">
        <button type="submit" class="btn btn-success text-white px-5">保存する</button>
      </div>
    </form>
  </div>
</div>
<!-- .collapse-wrap -->

<div class="collapse-wrap mt-4">
  <div class="collapse-ttl" data-toggle="collapse" href="#settingDelivery">デリバリー設定</div>
  <div class="collapse" id="settingDelivery">
    <form action="{{ route('manage.setting.service.delivery.update', ['account' => $sub_domain]) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="delivery_shipping">
          送料
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="delivery_shipping" name="delivery_shipping"
            value="{{ $manage->delivery_shipping }}" required />
          <div class="input-group-prepend">
            <div class="input-group-text">円(税込)</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="delivery_shipping_min">最低注文金額</label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="delivery_shipping_min" name="delivery_shipping_min"
            value="{{ $manage->delivery_shipping_min }}" />
          <div class="input-group-prepend">
            <div class="input-group-text">円以上(税込)</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="delivery_shipping_free">送料無料設定</label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="delivery_shipping_free" name="delivery_shipping_free"
            value="{{ $manage->delivery_shipping_free }}" />
          <div class="input-group-prepend">
            <div class="input-group-text">円以上(税込)</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="">キャンセルについて</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="cancelDelivery" value="0" id="cancelDeliveryFalse"
            @if($manage->delivery_cancel == 0)checked @endif />
          <label class="form-check-label text-body" for="cancelDeliveryFalse">受け付けない</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="cancelDelivery" value="1" id="cancelDeliveryTrue"
            @if($manage->delivery_cancel == 1)checked @endif />
          <label class="form-check-label text-body" for="cancelDeliveryTrue">受け付ける</label>
        </div>
      </div>
      <div class="form-group">
        <label for="delivery_preparation">
          ご注文受け付け時間
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="delivery_preparation" name="delivery_preparation" value="{{ $manage->delivery_preparation }}" required />
          <div class="input-group-prepend">
            <div class="input-group-text">分前</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="delivery_preparation">
          営業時間
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        @foreach ($weeks as $id => $week)
        <div class="form-check flex-wrap">
          @php
          if($manage->{'delivery_'.$id} != null) {
              $l_start = explode(',', $manage->{'delivery_'.$id})[0];
              $l_end = explode(',', $manage->{'delivery_'.$id})[1];
              $d_start = explode(',', $manage->{'delivery_'.$id})[2];
              $d_end = explode(',', $manage->{'delivery_'.$id})[3];
          } else {
              $l_start = null;
              $l_end = null;
              $d_start = null;
              $d_end = null;
          }
          @endphp

          <input class="form-check-input" type="checkbox" name="delivery_{{ $id }}" value="1" id="delivery_{{ $id }}"@if($manage->{'delivery_'.$id} != null)checked @endif />
          <label class="form-check-label text-body mr-3" for="">{{ $week }}</label>
          <div class="d-md-none w-100 mt-2"></div>

          <span class="mr-2">ランチ</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($l_start !== null && explode(':', $l_start)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($l_start !== null && explode(':', $l_start)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($l_end !== null && explode(':', $l_end)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_lunch_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($l_end !== null && explode(':', $l_end)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <div class="d-md-none w-100 mt-2"></div>

          <span class="ml-md-3 mr-2">ディナー</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_start_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($d_start !== null && explode(':', $d_start)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_start_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($d_start !== null && explode(':', $d_start)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
          <span class="mx-1">〜</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_end_hours_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 24; $i++)
            <option value="{{ $i }}"@if($d_end !== null && explode(':', $d_end)[0] == $i) selected @endif>{{ $i }}</option>
            @endfor
          </select>
          <span class="mx-1">：</span>
          <select class="form-control form-control-sm w-auto py-0 px-1 border" name="delivery_dinner_end_seconds_{{ $id }}">
            <option value="">--</option>
            @for ($i = 0; $i <= 45; $i+=15)
            <option value="{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}"@if($d_end !== null && explode(':', $d_end)[1] == str_pad($i, 2, 0, STR_PAD_LEFT)) selected @endif>{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
            @endfor
          </select>
        </div>
        @endforeach
      </div>
      <div class="form-group">
        <label for="delivery_area">
          デリバリーエリア詳細
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        <textarea class="form-control" id="delivery_area" name="delivery_area" cols="30" rows="5">{!! $manage->delivery_area !!}</textarea>
      </div>
      <div class="form-group">
        <label for="">キャンセル受付時間</label>
        <div class="form-inline">
          <span>お受取り時間の</span>
          <input type="number" name="" value="0" class="form-control p-2 mx-2 w-auto" min="0" max="9999" id="" />
          <span>分前まで</span>
        </div>
      </div>
      <div class="mt-4 text-center">
        <button type="submit" class="btn btn-success text-white px-5">保存する</button>
      </div>
    </form>
  </div>
</div>

<div class="collapse-wrap mt-4">
  <div class="collapse-ttl" data-toggle="collapse" href="#settingEC">通販設定</div>
  <div class="collapse" id="settingEC">
    <form action="{{ route('manage.setting.service.ec.update', ['account' => $sub_domain]) }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="ec_min_days">最短配送目安<span class="badge badge-warning text-white ml-1">必須</span></label>
        <div class="input-group w-50">
          <input type="number" min="1" class="form-control" id="ec_min_days" name="ec_min_days"
            value="{{ $manage->ec_min_days }}" required />
          <div class="input-group-prepend">
            <div class="input-group-text">日後</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="ec_delivery_time">配達時間<span class="badge badge-warning text-white ml-1">必須</span></label>
        <textarea class="form-control" id="ec_delivery_time" name="ec_delivery_time" cols="30" rows="5"
        placeholder="午前中&#13;&#10;12:00-15:00" required>{!! $manage->ec_delivery_time !!}</textarea>
      </div>
      <div class="form-group">
        <label for="ec_shipping">
          送料
          <span class="badge badge-warning text-white ml-1">必須</span>
        </label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="ec_shipping" name="ec_shipping"
            value="{{ $manage->ec_shipping }}" required />
          <div class="input-group-prepend">
            <div class="input-group-text">円(税込)</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="ec_shipping_free">送料無料設定</label>
        <div class="input-group w-50">
          <input type="number" min="0" class="form-control" id="ec_shipping_free" name="ec_shipping_free"
            value="{{ $manage->ec_shipping_free }}" />
          <div class="input-group-prepend">
            <div class="input-group-text">円以上(税込)</div>
          </div>
        </div>
      </div>
      <div class="mt-4 text-center">
        <button type="submit" class="btn btn-success text-white px-5">保存する</button>
      </div>
    </form>
  </div>
</div>
<!-- .collapse-wrap -->
@endsection