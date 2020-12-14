<div class="page-tab mb-4">
  <a href="{{ route('manage.data.order', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.data.order' ) class="active" @endif>
    <i data-feather="send"></i>
    <span>注文分析</span>
  </a>
  {{-- <a href="{{ route('manage.data.member', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.data.member' ) class="active" @endif>
    <i data-feather="image"></i>
    <span>会員分析</span>
  </a> --}}
</div>