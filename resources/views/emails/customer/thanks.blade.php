{{ $user['name'] }} 様

{{ $manages->name }}です。
この度は{{ $service }}をご利用頂きまして誠にありがとうございます。

以下の内容で、注文を承りました。

＜注文内容＞

～ お受け取り日時 ～
{{ $data['date_time'] }}

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
[その他ご要望] {{ $user['other'] }}

@foreach ($data['carts'] as $c)
{{ $c['name'] }}
オプション：@foreach ($c['options'] as $opt){{ $opt[0].' ' }}@endforeach

単価：{{ number_format($c['price']) }}円
数量：{{ number_format($c['quantity']) }}
小計：{{ number_format($c['amount']) }}円
-----------------------------------------------------
@endforeach

@if($user['shipping'] != 0)
[送料]：{{ number_format($user['shipping']) }}円
-----------------------------------------------------
@endif
[合計金額]：{{ number_format($data['total_amount']) }}円
-----------------------------------------------------

★ご注意下さい★
■ 受注後に品切れのご連絡をさせていただく場合がございます。ご了承ください。
■ クレジットカード決済をご利用の場合、お客様が受け取りにいらっしゃらない場合でも、代金はかかりますのでご了承ください。

※当メールは送信専用メールアドレスから配信されています。
