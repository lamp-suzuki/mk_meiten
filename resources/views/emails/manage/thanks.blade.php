{{ $user['name'] }} 様

{{ $manages->name }}です。
この度は{{ $service }}をご利用頂きまして誠にありがとうございます。

以下の内容で、注文を承りました。

＜注文内容＞

～ お受け取り日時 ～
{{ $data['date_time'] }}

[ジョイフルバトン会員カード] {{ $user['joyful'] == 0 ? 'あり:' : 'なし' }}{{ $user['joyful_no'] }}
[注文者様名] {{ $user['name'] }} 様
[注文者様名（フリガナ）] {{ $user['furigana'] }}
[メールアドレス] {{ $user['email'] }}
@if ($user['birth_day'])
[生年月日] {{ $user['birth_day'] }}
@endif
@if(isset($user['zipcode']) && $user['zipcode'] != null && $user['zipcode'] != '')
[ご住所] 〒{{ $user['zipcode'] }}
{{ $user['address1'] }}{{ $user['address2'] }}
@endif
[お電話番号] {{ $user['tel'] }}
[お支払方法] {{ $user['payment'] }}
[お受取方法] {{ $service }}
@if ($shop !== null)
[ご注文店舗] {{ $shop->name }}
@endif
[その他ご要望] {{ $user['other'] }}

@foreach ($data['carts'] as $c)
{{ $c['name'] }}
オプション：@foreach ($c['options'] as $opt){{ $opt[0].' ' }}@endforeach

単価：{{ number_format($c['price']) }}円
数量：{{ number_format($c['quantity']) }}
小計：{{ number_format($c['amount']) }}円
-----------------------------------------------------
@endforeach

[消費税]：{{ number_format($user['tax']) }}円
-----------------------------------------------------
@if($user['shipping'] != 0)
[送料]：{{ number_format($user['shipping']) }}円
-----------------------------------------------------
@endif
[入会料]：{{ number_format($user['joyful']) }}円
-----------------------------------------------------
[合計金額]：{{ number_format($data['total_amount']) }}円
-----------------------------------------------------

@if ($service == '店舗受け取り')
★★★重要★★★
［受け取りに関しての注意事項］
・お受け取りの際は、この「注文内容確認メール」または、印刷した用紙を店舗スタッフへご提示ください。
・「北山本店」受け取りのお客様：お受け取りは店舗西隣の「コンシェルジュルーム」へお越しください。

［キャンセルに関しての注意事項］
商品の性質上、ご予約いただいてからのキャンセル・ご注文内容の変更はご容赦ください。
@endif

★ご注意下さい★
■ 受注後に品切れのご連絡をさせていただく場合がございます。ご了承ください。
■ クレジットカード決済をご利用の場合、お客様が受け取りにいらっしゃらない場合でも、代金はかかりますのでご了承ください。

※当メールは送信専用メールアドレスから配信されています。
