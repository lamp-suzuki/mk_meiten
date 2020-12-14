@extends('layouts.shop.app')

@section('page_title', '特定商取引法に基づく表記')

@section('content')
<section class="mv bg-light">
  <div class="container">
    <h2>特定商取引法に基づく表記</h2>
  </div>
</section>

<section class="bg-white py-4 rounded mb-5">
  <div class="container single">
    <table class="table m-0 w-100">
      <tbody>
        <tr>
          <th>事業者の名称</th>
          <td>{{ $transactions->name }}</td>
        </tr>
        <tr>
          <th>事業者の所在地</th>
          <td>〒{{ $transactions->zipcode }}
            <br>{{ $transactions->address1 }}{{ $transactions->address2 }}
          </td>
        </tr>
        <tr>
          <th>事業者の連絡先</th>
          <td>
            <span class="d-block">{{ $transactions->tel }}</span>
            <span class="d-block">{{ $transactions->business }}</span>
          </td>
        </tr>
        <tr>
          <th>販売価格について</th>
          <td>{{ $transactions->selling_price }}</td>
        </tr>
        <tr>
          <th>代金（対価）の支払方法と時期</th>
          <td>{{ $transactions->payment_method }}</td>
        </tr>
        <tr>
          <th>役務または商品の引渡時期</th>
          <td>{{ $transactions->delivery_time }}</td>
        </tr>
        <tr>
          <th>返品についての特約に関する事項</th>
          <td>{{ $transactions->returns }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
@endsection