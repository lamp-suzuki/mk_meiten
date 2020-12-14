@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">注文分析</h2>

{{-- menu --}}
@include('manage.data.menu')

<div class="content">
  <div class="content-head">
    <h3>
      <i data-feather="bar-chart"></i>
      <span>今月の売上は？</span>
    </h3>
  </div>
  <div class="content-body">
    {{-- <div class="btn-group mb-3" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-outline-primary"></button>
      <button type="button" class="btn btn-outline-primary">Middle</button>
      <button type="button" class="btn btn-outline-primary">Right</button>
    </div> --}}
    <canvas id="chartSales"></canvas>
  </div>
</div>

<div class="content">
  <div class="content-head">
    <h3>
      <i data-feather="bar-chart"></i>
      <span>よく注文される商品は？</span>
    </h3>
  </div>
  <div class="content-body">
    @foreach ($rankings as $index => $ranking)
    <div class="row ranking mx-0 mb-3">
      <span class="col-1 px-0">{{ $index+1 }}</span>
      <div class="thumbnail col-lg-3 col-4 pl-0">
        @if ($ranking['thumbnail'] != null && $ranking['thumbnail'] != '')
        <img src="{{ url('/') }}/{{ $ranking['thumbnail'] }}" alt="{{ $ranking['name'] }}">
        @endif
      </div>
      <div class="info col-lg-8 col-7 px-0">
        <p class="font-weight-bold mb-1">{{ $ranking['name'] }}</p>
        <p class="mb-1">￥<span class="text-primary font-weight-bold"
            style="font-size:120%">{{ number_format($ranking['price']) }}</span></p>
        <p class="mb-0 small"><span class="text-muted">今月の注文数：</span>{{ number_format($ranking['counts']) }}</p>
      </div>
    </div>
    @endforeach
  </div>
</div>


<!-- chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
  let configSales = {
    type: "line",
    data: {
      labels: {!! json_encode($labels) !!},
      datasets: [
        {
          label: "売上",
          data: {!! json_encode($data) !!},
          borderColor: "#FB4B1B",
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            userCallback: function(label, index, labels) {
              if (Math.floor(label) === label) {
                return label;
              }
            }
          }
        }]
      }
    },
  };
  window.onload = function () {
    let chartSales = document.getElementById("chartSales").getContext("2d");
    window.myLine = new Chart(chartSales, configSales);
  };
</script>
@endsection