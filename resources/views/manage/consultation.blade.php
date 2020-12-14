@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">無料相談会お申し込み</h2>
<p class="text-center font-weight-bold">基本操作から売上アップのポイントまでを<br>サポートいたします。</p>
<p class="text-center mb-3 mt-4 small">下記カレンダーよりご希望の日時を選択してください。</p>
<iframe src="https://takeeats.youcanbook.me/?noframe=true&skipHeaderFooter=true" id="ycbmiframetakeeats" style="width:100%;height:1000px;border:0px;background-color:transparent;" frameborder="0" allowtransparency="true"></iframe><script>window.addEventListener && window.addEventListener("message", function(event){if (event.origin === "https://takeeats.youcanbook.me"){document.getElementById("ycbmiframetakeeats").style.height = event.data + "px";}}, false);</script>
@endsection