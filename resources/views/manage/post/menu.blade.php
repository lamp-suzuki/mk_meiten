<div class="page-tab">
  <a href="{{ route('manage.post.index', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.post.index' ) class="active" @endif>
    <i data-feather="send"></i>
    <span>お知らせ一覧</span>
  </a>
  <a href="{{ route('manage.post.slide', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.post.slide' ) class="active" @endif>
    <i data-feather="image"></i>
    <span>スライドショー</span>
  </a>
  <a href="{{ route('manage.post.guide', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.post.guide' ) class="active" @endif>
    <i data-feather="book"></i>
    <span>ご利用ガイド</span>
  </a>
</div>