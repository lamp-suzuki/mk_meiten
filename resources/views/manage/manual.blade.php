@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">ご利用マニュアルのダウンロード</h2>
<p class="text-center font-weight-bold">基本操作から売上アップのポイントまで<br>すべてご紹介！</p>
<p class="text-center">
  <img src="{{ asset('images/manual.png') }}" alt="ご利用マニュアルのダウンロード" srcset="{{ asset('images/manual.png') }} 1x, {{ asset('images/manual@2x.png') }} 2x">
</p>
<p class="text-lg-center">アカウント発行後から注文を受けるまでの流れに沿って、使い方や写真撮影のポイントまで幅広くご紹介いたします。</p>
<div class="text-center mt-4">
  <a class="btn btn-success px-5 py-3 text-white" href="{{ asset('pdf/manual.pdf') }}" target="_blank">ダウンロードする</a>
</div>
@endsection