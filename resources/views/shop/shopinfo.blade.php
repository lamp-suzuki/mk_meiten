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
    <table>
      <tbody>
        <tr>
          <th>店名</th>
          <td>{{ $manages->name }}({{ $shops->name }})</td>
        </tr>
        <tr>
          <th>住所</th>
          <td>〒{{ $shops->zipcode }}
            <br>{{ $shops->address1 }} {{ $shops->address2 }}
          @if ($shops->googlemap_url != null)
          <br>
          <a class="btn btn-outline-secondary text-body py-1" href="{{ $shops->googlemap_url }}" target="_blank">
            <i class="text-primary" data-feather="map"></i>
            <span>GoogleMapでみる</span>
          </a>
          @endif
          </td>
        </tr>
        @if ($shops->access != null)
        <tr>
          <th>アクセス</th>
          <td>{{ $shops->access }}</td>
        </tr>
        @endif
        @if ($shops->parking != null)
        <tr>
          <th>駐車場</th>
          <td>{{ $shops->parking }}</td>
        </tr>
        @endif
        <tr>
          <th>電話番号</th>
          <td>{{ $shops->tel }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
@endsection