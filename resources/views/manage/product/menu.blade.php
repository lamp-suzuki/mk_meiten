<div class="page-tab">
  <a href="{{ route('manage.product.index', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.product.index' ) class="active" @endif>
    <i data-feather="book"></i>
    <span>商品一覧</span>
  </a>
  <a href="{{ route('manage.product.category.index', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.product.category.index' ) class="active" @endif>
    <i data-feather="tag"></i>
    <span>カテゴリ</span>
  </a>
  <a href="{{ route('manage.product.option.index', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.product.option.index' ) class="active" @endif>
    <i data-feather="plus-square"></i>
    <span>オプション</span>
  </a>
</div>