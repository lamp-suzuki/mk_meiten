@extends('layouts.shop.app')

@section('page_title', 'ご利用ガイド')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>ご利用ガイド</h2>
  </div>
</section>
<section class="bg-white py-4 rounded mb-5">
  <div class="container single">
    @if ($guide !== null)
    {!! $guide->contents !!}
    @endif
  </div>
</section>
@endsection