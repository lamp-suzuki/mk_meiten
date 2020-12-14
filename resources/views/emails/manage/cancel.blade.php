{{ $users['name'] }} 様

この度はご利用いただき、誠にありがとうございます。
ご注文のキャンセル手続きが完了致しました。

＜注文内容＞

～ お受け取り日時 ～
{{ $users['delivery_time'] }}

[ジョイフルバトン会員カード] {{ $users['joyful_no'] == null ? 'なし' : 'あり:'.$users['joyful_no'] }}
[注文者様名] {{ $users['name'] }} 様
[注文者様名（フリガナ）] {{ $users['furigana'] }}
[メールアドレス] {{ $users['email'] }}
[生年月日] {{ $users['birth_day'] }}
[ご住所] 〒{{ $users['zipcode'] }}
{{ $users['pref'] }}{{ $users['address1'] }}{{ $users['address2'] }}
[お電話番号] {{ $users['tel'] }}
[お支払方法] {{ $users['payment_method'] }}
[お受取方法] {{ $users['service'] }}
[その他ご要望] {{ $users['memo'] }}

@foreach ($users['products'] as $c)
{{ $c['name'] }}
{{ $c['options'] }}
単価：{{ number_format($c['price']) }}円
数量：{{ number_format($c['quantity']) }}
小計：{{ number_format($c['amount']) }}円
-----------------------------------------------------
@endforeach

[消費税]：{{ number_format($users['tax']) }}円
-----------------------------------------------------
[送料]：{{ number_format($users['shipping']) }}円
-----------------------------------------------------
[入会料]：{{ $users['joyful_no'] == null ? '300' : '0' }}円
-----------------------------------------------------
[合計金額]：{{ number_format($users['total_amount']) }}円
-----------------------------------------------------

※当メールは送信専用メールアドレスから配信されています。