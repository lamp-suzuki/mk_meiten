{{ $users['name'] }} 様

この度はご利用いただき、誠にありがとうございます。
ご注文のキャンセル手続きが完了致しました。

＜注文内容＞

～ お受け取り日時 ～
{{ $users['delivery_time'] }}

[注文者様名] {{ $users['name'] }} 様
[注文者様名（フリガナ）] {{ $users['furigana'] }}
[メールアドレス] {{ $users['email'] }}

[合計金額]：{{ number_format($users['total_amount']) }}円

※当メールは送信専用メールアドレスから配信されています。