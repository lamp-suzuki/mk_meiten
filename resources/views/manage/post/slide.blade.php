@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">スライドショー管理</h2>

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
@include('manage.post.menu')

<div class="my-4">
  <div class="">
    <img src="{{ asset('images/ex_slide.png') }}" alt="トップページに表示する画像を4枚まで設定いただけます。"
      srcset="{{ asset('images/ex_slide.png') }} 1x, {{ asset('images/ex_slide@2x.png') }} 2x">
  </div>
  <p class="m-0 mt-3">トップページに表示する画像を5枚まで設定いただけます。<br class="d-md-inline d-none">表示させたい画像をアップロードし更新ボタンを押してください。</p>
</div>

<form action="{{ route('manage.post.slide.update', ['account' => $sub_domain]) }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="form-group row">
    <label class="col-3 col-form-label text-body font-weight-bold">1枚目</label>
    <div class="col-9 d-flex">
      <label class="form-img-label" for="slide_1">
        <input type="file" name="slide_1" accept=".jpg, .jpeg, .png, .gif" class="form-img-input form-img-change"
          id="slide_1" />
      </label>
      <div class="form-img-preview ml-2">
        @if ($slides != null && $slides->slide_1 != null)
        <img src="{{ url('/') }}/{{ $slides->slide_1 }}" width="200" alt="">
        <input type="hidden" name="slide_1_flag" value="true">
        @endif
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-3 col-form-label text-body font-weight-bold">2枚目</label>
    <div class="col-9 d-flex">
      <label class="form-img-label" for="slide_2">
        <input type="file" name="slide_2" accept=".jpg, .jpeg, .png, .gif" class="form-img-input form-img-change"
          id="slide_2" />
      </label>
      <div class="form-img-preview ml-2">
        @if ($slides != null && $slides->slide_2 != null)
        <img src="{{ url('/') }}/{{ $slides->slide_2}}" width="200" alt="">
        <input type="hidden" name="slide_2_flag" value="true">
        @endif
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-3 col-form-label text-body font-weight-bold">3枚目</label>
    <div class="col-9 d-flex">
      <label class="form-img-label" for="slide_3">
        <input type="file" name="slide_3" accept=".jpg, .jpeg, .png, .gif" class="form-img-input form-img-change"
          id="slide_3" />
      </label>
      <div class="form-img-preview ml-2">
        @if ($slides != null && $slides->slide_3 != null)
        <img src="{{ url('/') }}/{{ $slides->slide_3}}" width="200" alt="">
        <input type="hidden" name="slide_3_flag" value="true">
        @endif
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-3 col-form-label text-body font-weight-bold">4枚目</label>
    <div class="col-9 d-flex">
      <label class="form-img-label" for="slide_4">
        <input type="file" name="slide_4" accept=".jpg, .jpeg, .png, .gif" class="form-img-input form-img-change"
          id="slide_4" />
      </label>
      <div class="form-img-preview ml-2">
        @if ($slides != null && $slides->slide_4 != null)
        <img src="{{ url('/') }}/{{ $slides->slide_4}}" width="200" alt="">
        <input type="hidden" name="slide_4_flag" value="true">
        @endif
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-3 col-form-label text-body font-weight-bold">5枚目</label>
    <div class="col-9 d-flex">
      <label class="form-img-label" for="slide_5">
        <input type="file" name="slide_5" accept=".jpg, .jpeg, .png, .gif" class="form-img-input form-img-change"
          id="slide_5" />
      </label>
      <div class="form-img-preview ml-2">
        @if ($slides != null && $slides->slide_5 != null)
        <img src="{{ url('/') }}/{{ $slides->slide_5}}" width="200" alt="">
        <input type="hidden" name="slide_5_flag" value="true">
        @endif
      </div>
    </div>
  </div>

  <div class="mt-4 text-center">
    <button type="submit" class="btn btn-success text-white px-5">更新する</button>
  </div>
</form>
@endsection