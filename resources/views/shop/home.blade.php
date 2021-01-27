@extends('layouts.shop.app')

@section('content')

{{-- 受け取り方法 --}}
@if (session()->has('receipt') && $stop_flag === false)
@php
if (session('receipt.service') == 'takeout') {
    $service = 'お持ち帰り';
} elseif (session('receipt.service') == 'delivery') {
    $service = 'デリバリー';
} else {
    $service = '通販';
}
@endphp
<div id="changeDateBtn">
  <div class="container">
    @if (session('receipt.service') !== null)
    <span class="deli">{{ $service }}</span>
    @endif
    @if (session('receipt.date') !== null)
    <span class="date">{{ date('n月j日', strtotime(session('receipt.date'))).' '.session('receipt.time') }}</span>
    @endif
    @if (session('receipt.shop_name') !== null)
    <span class="shop">{{ session('receipt.shop_name') }}</span>
    @endif
    <div class="link" style="cursor: pointer">変更</div>
  </div>
</div>
@else
<div id="changeDateBtn">
  <div class="container">
    <span class="shop">受け取り方法未設定</span>
    <div class="link" style="cursor: pointer">変更</div>
  </div>
</div>
@endif

{{-- スライダー --}}
@if ($slides != null)
<div class="container home-slide-container">
  <div class="home-slide bg-white">
    @foreach ($slides as $key => $slide)
    @php
    if ($key == 'id' || $key == 'manages_id' || $key == 'created_at' || $key == 'updated_at') {
        continue;
    }
    @endphp
    @if ($slide != null)
    <div>
      <img src="{{ url('/') }}/{{ $slide }}" alt="バナー" />
    </div>
    @endif
    @endforeach
  </div>
</div>
@endif

{{-- お知らせ --}}
@if (isset($posts->title))
<div class="news bg-light py-3">
  <div class="container px-md-0">
    <a class="text-body d-block bg-white small p-3" href="{{ route('shop.info', ['account' => $sub_domain, 'id' => $posts->id]) }}">
      <span class="d-block text-secondary">{{ date('Y/m/d', strtotime($posts->updated_at)) }}</span>
      <span class="d-block">{{ $posts->title }}</span>
    </a>
  </div>
</div>
@endif

{{-- 商品一覧 --}}
<section id="catalog" class="catalog">
  <ul class="catalog-cat">
    {{-- <li><a class="active smooth" href="#catalog">すべて</a></li> --}}
    @foreach ($categories as $cat)
    @if (isset($products[$cat->id]))
    <li class="@if(count($products[$cat->id]) == 0) d-none @endif"><a class="smooth" href="#cat{{ $cat->id }}">{{ $cat->name }} ({{ count($products[$cat->id]) }})</a></li>
    @endif
    @endforeach
  </ul>
  <div class="py-4">
    <div class="container">
      @foreach ($categories as $cat)
      @if (isset($products[$cat->id]))
      <div id="cat{{ $cat->id }}" class="catalog-wrap @if(count($products[$cat->id]) == 0) d-none @endif">
        <h2>{{ $cat->name }}</h2>
        <div class="catalog-list">
          @php
          $counts = 0;
          @endphp
          @foreach ($products[$cat->id] as $product)
          @php
          // {{-- 除外店舗処理 --}}
          $only_shops = explode(',', $product->shops_id);
          array_pop($only_shops);
          if (session('receipt.shop_id') != null) {
              if (in_array((String)session('receipt.shop_id'), $only_shops) === false) {
                  continue;
              }
          }
          // {{-- 個別リードタイムスキップ --}}
          if ((session('receipt.date') != null && session('receipt.time') != null) && session('receipt.service') != 'ec') {
            if (strtotime(session('receipt.date').' '.session('receipt.time')) <= strtotime(date('Y-m-d H:i:s', strtotime('+'.$product->lead_time.' minutes')))) {
              continue;
            }
          }
          @endphp
          <div class="catalog-item">
            @if ($product->thumbnail_1 != null)
            <div class="catalog-thumbnail" data-toggle="modal" data-target="#modal-item{{ $product->id }}">
              <img src="{{ url($product->thumbnail_1 ) }}" alt="{{ $product->name }}" />
            </div>
            @endif
            <div class="catalog-name">
              <span>{{ mb_strimwidth($product->name, 0, 50, '…') }}</span>
            </div>
            <div class="catalog-price">
              <span class="catalog-price-num">{{ number_format($product->price) }}</span>
              <span class="catalog-price-tax">（税込）</span>
            </div>
            @if (session()->has('receipt.date') && session()->has('receipt.time'))
            <div class="catalog-btn">
              @if (isset($stocks[$product->id]) && $stocks[$product->id] <= 0)
              <button class="btn btn-block btn-dark" type="button">売り切れ</button>
              @else
              <button class="btn btn-block btn-primary" type="button" data-toggle="modal"
                data-target="#modal-item{{ $product->id }}">数量・オプションを選ぶ</button>
              @endif
            </div>
            @endif
            {{-- modal --}}
            <div class="modal catalog-modal fade" id="modal-item{{ $product->id }}" tabindex="-1"
              aria-labelledby="modal-item{{ $product->id }}Label" aria-hidden="true">
              <div class="modal-dialog">
                <form action="{{ route('shop.addcart', ['account' => $sub_domain]) }}" method="POST">
                  @csrf
                  <div class="modal-content">
                    <span class="modal-close-icon" data-dismiss="modal" aria-label="Close">
                      <i data-feather="x"></i>
                      <i>閉じる</i>
                    </span>
                    <div class="modal-header">
                      @if ($product->thumbnail_1 != null)
                      <div id="modal-item{{ $product->id }}-slide" class="carousel slide w-100" data-ride="carousel">
                        <ol class="carousel-indicators">
                          @if ($product->thumbnail_1 != null)
                          <li data-target="#modal-item{{ $product->id }}-slide" data-slide-to="0" class="active"></li>
                          @endif
                          @if ($product->thumbnail_2 != null)
                          <li data-target="#modal-item{{ $product->id }}-slide" data-slide-to="1"></li>
                          @endif
                          @if ($product->thumbnail_3 != null)
                          <li data-target="#modal-item{{ $product->id }}-slide" data-slide-to="2"></li>
                          @endif
                        </ol>
                        <div class="carousel-inner">
                          @if ($product->thumbnail_1 != null)
                          <div class="carousel-item active">
                            <img src="{{ url($product->thumbnail_1 ) }}" class="d-block w-100"
                              alt="{{ $product->name }}" />
                          </div>
                          @endif
                          @if ($product->thumbnail_2 != null)
                          <div class="carousel-item">
                            <img src="{{ url('/') }}/{{ $product->thumbnail_2 }}" class="d-block w-100"
                              alt="{{ $product->name }}" />
                          </div>
                          @endif
                          @if ($product->thumbnail_3 != null)
                          <div class="carousel-item">
                            <img src="{{ url('/') }}/{{ $product->thumbnail_3 }}" class="d-block w-100"
                              alt="{{ $product->name }}" />
                          </div>
                          @endif
                        </div>
                        <a class="carousel-control-prev" href="#modal-item{{ $product->id }}-slide" role="button"
                          data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#modal-item{{ $product->id }}-slide" role="button"
                          data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                      </div>
                      @endif
                    </div>
                    <div class="modal-body">
                      <div class="p-3">
                        <h3 class="title">{{ $product->name }}</h3>
                        <p>{!! nl2br($product->explanation) !!}</p>
                        <div class="price">
                          <span class="price-num">{{ number_format($product->price) }}</span>
                          <span class="price-tax">（税込）</span>
                        </div>
                      </div>
                      @if (isset($options[$cat->id]))
                      @php
                      if ($product->options_id != '' && $product->options_id != null) {
                          $product_options = explode(',', $product->options_id);
                          array_pop($product_options);
                      } else {
                          $product_options = [];
                      }
                      @endphp
                      <div class="option">
                        @foreach ($options[$cat->id] as $opt)
                        @if(in_array((String)$opt->id, $product_options))
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox"
                            name="options[]"
                            value="{{ $opt->id }}"
                            id="product{{ $product->id }}_opt{{ $opt->id }}" />
                          <label class="form-check-label" for="product{{ $product->id }}_opt{{ $opt->id }}">
                            <span>{{ $opt->name }}</span>
                            <span class="yen">@if($opt->price>=0)+@endif{{ number_format($opt->price) }}</span>
                          </label>
                        </div>
                        @endif
                        @endforeach
                      </div>
                      @endif
                      @if (isset($stocks[$product->id]) && $stocks[$product->id] > 0 && $stop_flag === false)
                      <div class="number">
                        <input class="num-spinner" type="number" name="quantity" value="1" min="1" max="50" step="1" />
                      </div>
                      @endif
                    </div>
                    @if (isset($stocks[$product->id]) && $stocks[$product->id] > 0 && $stop_flag === false)
                    <div class="modal-footer">
                      <div class="btn-group m-0 w-100" role="group">
                        <button type="button"
                          class="addcart btn btn-primary rounded-0 w-100 font-weight-bold py-3">カートに追加</button>
                      </div>
                      <p class="modal-close" data-dismiss="modal" aria-label="Close">メニューに戻る</p>
                    </div>
                    @endif
                  </div>
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                </form>
              </div>
            </div>
          </div>
          @php
          ++$counts;
          @endphp
          @endforeach
          @if ($counts == 0)
          <p>選択された日時に、注文可能な商品がございません。</p>
          @endif
        </div>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</section>

{{-- カート --}}
<div class="cartstatus">
  <span class="count">{{ session('cart.total') == null ? 0 : session('cart.total') }}</span>
  <span class="price">{{ session('cart.amount') == null ? 0 : number_format(session('cart.amount')) }}</span>
  <a class="btn btn-primary rounded-pill" href="{{ route('shop.cart', ['account' => $sub_domain]) }}">次へ進む</a>
</div>

{{-- お受け取り設定 --}}
@if ($stop_flag === false)
<div class="modal fsmodal catalog-modal fade" id="FirstSelect" tabindex="-1" aria-labelledby="FirstSelectLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="tab-content">
          <input type="hidden" name="service" id="set-service" value="">
          <div id="step1" class="tab-pane fade">
            <h3>
              <span>STEP1</span>
              <span>お受け取り方法を選択</span>
            </h3>
            @if ($manages->takeout_flag == 1)
            <button class="btn btn-primary btn-select" type="button" name="takeout">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="26.745" height="26.742" viewBox="0 0 26.745 26.742">
                  <path
                    d="M1007.627,1359.121a.549.549,0,0,0-.577-.514h0a.544.544,0,0,0-.508.579l.328,5.424H988.311v-16.949h17.528l.432,7.157a.546.546,0,0,0,.58.514h0a.542.542,0,0,0,.513-.574v-.011l-.464-7.665a.564.564,0,0,0-.011-.069c0-.005,0-.01,0-.015a.546.546,0,0,0-.045-.128l0-.006-2.126-4.252v-2.6a.547.547,0,0,0-.546-.547H985.577a.547.547,0,0,0-.547.547v2.6l-2.129,4.258a.539.539,0,0,0-.057.211l-1.093,18.042a.546.546,0,0,0,.546.58h25.149a.554.554,0,0,0,.4-.169.547.547,0,0,0,.148-.41Zm-22.664-13.927-.478,17.214a.547.547,0,0,0,.532.562h.016a.547.547,0,0,0,.546-.532l.486-17.5,1.154,2.308v17.366h-4.339l1.051-17.35Zm8.816-4.64h2.733v1.64h-2.733Zm2.749,3.37a.946.946,0,0,1-.82.457h-.448a.958.958,0,0,1-.862-.533l-.28-.56h2.549A.949.949,0,0,1,996.527,1343.924Zm-8.425,2.644-.872-1.745-.768-1.535h6.431l.525,1.049a2.045,2.045,0,0,0,1.84,1.138h.448a2.057,2.057,0,0,0,2.054-2.187h6.067l1.64,3.28Zm15.517-4.374h-6.014v-1.64h6.014Zm-10.934,0h-6.56v-1.64h6.56Zm14.811,14.745a.542.542,0,0,1-.513.574h0a.069.069,0,0,1-.033.005.547.547,0,0,1-.033-1.093h0A.54.54,0,0,1,1007.5,1356.94Zm-12.624-2.717h5.467a.547.547,0,1,1,0,1.093h-5.467a.547.547,0,1,1,0-1.093Zm4.374-2.734a1.64,1.64,0,1,0-1.64,1.64A1.642,1.642,0,0,0,999.245,1351.489Zm-1.64-.547a.547.547,0,1,1-.547.547A.547.547,0,0,1,997.605,1350.942Zm-7.654,6.561v5.467a.546.546,0,0,0,.547.547h14.214a.547.547,0,0,0,.547-.547V1357.5a.547.547,0,0,0-.547-.547H990.5A.546.546,0,0,0,989.951,1357.5Zm14.215,4.92H991.045v-4.374h13.121Z"
                    transform="translate(-981.5 -1339.211)" fill="#eb5a3c" stroke="#eb5a3c" stroke-width="0.5" />
                </svg>
              </div>
              <div class="txt">
                <p class="ttl">店舗受け取り</p>
                <p class="desc">クリスマスケーキ予約</p>
              </div>
            </button>
            @endif
            @if ($manages->delivery_flag == 1)
            <button class="btn btn-primary btn-select mt-3" type="button" name="delivery">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30.918" height="30.918" viewBox="0 0 30.918 30.918">
                  <g transform="translate(1 1)">
                    <path d="M1795.772,2574.029l-3.772,1.886V2569" transform="translate(-1782.57 -2566.486)" fill="none"
                      stroke="#eb5a3c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    <path d="M1690.859,2544.557a9.608,9.608,0,0,0-9.43-7.557,9.411,9.411,0,0,0-6.236,16.475"
                      transform="translate(-1672 -2537)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <path
                      d="M1702.988,2673h5.2v2.515l-1.257,1.257,3.3,6.156a4.434,4.434,0,0,1,3.615,3.274h-5.029l-3.772,3.143h-7.544l-1.886-2.514h-9.43c-.629-1.886.629-6.287,4.4-6.287h6.672a1.257,1.257,0,0,1,1.177.816l1.58,4.213h3.772c1.284-.9,2.167-1.937,1.831-3.206l-1.831-5.595v-1.257l-3.143-1.258"
                      transform="translate(-1684.933 -2662.313)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <path d="M1712.806,2873.031a3.144,3.144,0,0,0,6.156.015" transform="translate(-1709.6 -2846.625)"
                      fill="none" stroke="#eb5a3c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    <path d="M1957.995,2866.656a3.144,3.144,0,0,0,5.815-1.656"
                      transform="translate(-1935.521 -2839.226)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <rect width="8.733" height="3.275" rx="1.637" transform="translate(5.297 15.122)" fill="none"
                      stroke="#eb5a3c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                  </g>
                </svg>
              </div>
              <div class="txt">
                <p class="ttl">デリバリー</p>
                <p class="desc">今スグ食べたいときに</p>
              </div>
            </button>
            @endif
            @if ($manages->ec_flag == 1)
            <button class="btn btn-primary btn-select mt-3" type="button" name="ec">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="22.565" viewBox="0 0 34 22.565">
                  <g transform="translate(1 1)">
                    <path
                      d="M1920,761h4.757a1.371,1.371,0,0,1,1.132.6l2.333,4.883h.685a1.344,1.344,0,0,1,1.37,1.514v3.965a1.372,1.372,0,0,1-1.37,1.372h-1.37"
                      transform="translate(-1898.277 -755.508)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <path d="M1784,697h11.647v17.814h-10.962" transform="translate(-1773.925 -696.989)" fill="none"
                      stroke="#eb5a3c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    <line x1="3" transform="translate(2 18)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <path d="M1949.351,875.876a2.747,2.747,0,1,1-2.747-2.734A2.741,2.741,0,0,1,1949.351,875.876Z"
                      transform="translate(-1920.092 -858.046)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <path d="M1733.493,875.876a2.747,2.747,0,1,1-2.747-2.734A2.741,2.741,0,0,1,1733.493,875.876Z"
                      transform="translate(-1722.721 -858.046)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <line x2="2" transform="translate(22 18)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <line x2="7" transform="translate(23 11)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <line x2="11" transform="translate(0 4)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <line x2="9" transform="translate(6 9)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <line x1="2" transform="translate(3 9)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                    <line x1="2" transform="translate(7)" fill="none" stroke="#eb5a3c" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                  </g>
                </svg>
              </div>
              <div class="txt">
                <p class="ttl">デリバリー</p>
                <p class="desc">お家で商品を受け取り</p>
              </div>
            </button>
            @endif
          </div>
          <div id="step2" class="tab-pane fade">
            <h3>
              <span>STEP2</span>
              <span>お受け取り店舗を選択</span>
            </h3>
            <div class="form-group">
              <select id="deliveryShop" class="form-control" name="deliveryShop">
                <option value="">店舗を選択</option>
                @foreach ($shops as $shop)
                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="text-center mt-4">
              <button class="btn-step-back mr-1" type="button">
                <i data-feather="arrow-left"></i>
              </button>
              <button class="btn btn-primary rounded-pill" type="button" name="next" style="min-width: 200px;" disabled>次へ進む</button>
            </div>
          </div>
          <div id="step3" class="tab-pane fade show active">
            <h3>
              <span></span>
              <span>お受け取り日時を選択</span>
            </h3>
            <div class="form-group">
              <select id="deliveryDate" class="form-control" name="delivery_date">
                @for ($i = 0; $i <= 13; $i++)
                <option value="{{ date('Y-m-d', strtotime('+'.$i.' day')) }}">{{ date('Y年n月j日', strtotime('+'.$i.' day')) }}@if($i == 0)（本日）@elseif($i == 1)（明日）@endif</option>
                @endfor
              </select>
            </div>
            <div class="form-group">
              <select id="delivery_time" class="form-control" name="delivery_time">
                <option value="">--:--</option>
              </select>
            </div>
            <small id="datevali" class="form-text text-danger" style="display: none">有効な日時をご選択ください</small>
            <div class="text-center mt-4">
              {{-- <button class="btn-step-back mr-1" type="button">
                <i data-feather="arrow-left"></i>
              </button> --}}
              <button class="btn btn-primary rounded-pill" id="nextstep3" type="button" style="min-width: 200px;">メニュー選択に進む</button>
            </div>
          </div>
        </div>
        {{-- <div id="first-progress" class="progress">
          <span class="steps">1/3</span>
          <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0"
            aria-valuemax="100"></div>
        </div> --}}
      </div>
      <div class="modal-footer" data-dismiss="modal" aria-label="Close">
        <p class="modal-close" data-dismiss="modal" aria-label="Close">まずはメニューをみる</p>
      </div>
    </div>
  </div>
</div>
@endif

{{-- hidden_flag --}}
@if ($stop_flag === true)
<div class="modal fade" id="salestop" tabindex="-1" role="dialog" aria-labelledby="salestopTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-body">
        <div class="pt-4">
          <p class="text-center">
            <i class="text-primary" data-feather="alert-triangle" width="32px" hegiht="32px"></i>
          </p>
          <p class="text-center font-weight-bold mb-3 h5">ただいま一時的に<br>ご注文の受付を<br>ストップしております</p>
          <p class="text-center small mb-0">ご迷惑をお掛けいたしますが<br>何卒ご理解いただけますよう<br>お願い申し上げます。</p>
        </div>
      </div>
      <div class="modal-footer text-center justify-content-center border-0 pb-4">
        <button type="button" class="btn btn-primary rounded-pill" data-dismiss="modal">メニューを見る</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection