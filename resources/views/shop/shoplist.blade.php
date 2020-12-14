@extends('layouts.shop.app')

@section('page_title', '店舗情報')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>店舗情報</h2>
  </div>
</section>
<section class="bg-white py-4 rounded mb-5">
  <div class="container single">
    @foreach ($shops as $shop)
    <table class="w-100 mb-0">
      <tbody>
        <tr>
          <th width="15%">店名</th>
          <td>{{ $manages->name }}({{ $shop->name }})</td>
        </tr>
        <tr>
          <th width="15%">住所</th>
          <td>〒{{ $shop->zipcode }}
            <br>{{ $shop->address1 }} {{ $shop->address2 }}
          @if ($shop->googlemap_url != null)
          <br>
          <a class="btn btn-outline-secondary text-body py-1" href="{{ $shop->googlemap_url }}" target="_blank">
            <i class="text-primary" data-feather="map"></i>
            <span>GoogleMapでみる</span>
          </a>
          @endif
          </td>
        </tr>
        @if ($shop->access != null)
        <tr>
          <th width="15%">アクセス</th>
          <td>{{ $shop->access }}</td>
        </tr>
        @endif
        @if ($shop->parking != null)
        <tr>
          <th width="15%">駐車場</th>
          <td>{{ $shop->parking }}</td>
        </tr>
        @endif
        <tr>
          <th width="15%">電話番号</th>
          <td>{{ $shop->tel }}</td>
        </tr>
      </tbody>
    </table>
    <hr class="my-4">
    @endforeach
  </div>
</section>
@endsection