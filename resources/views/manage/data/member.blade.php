
@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">会員分析</h2>

{{-- menu --}}
@include('manage.data.menu')

{{-- <div class="content">
  <div class="content-head">
    <h3>
      <i data-feather="bar-chart"></i>
      <span>期間別の売上は？</span>
    </h3>
  </div>
  <div class="content-body">
    <canvas id="chartSales"></canvas>
  </div>
</div> --}}
<!-- .content -->
{{-- <div class="content">
  <div class="content-head">
    <h3>
      <i data-feather="bar-chart"></i>
      <span>期間別の注文数は？</span>
    </h3>
  </div>
  <div class="content-body">
    <canvas id="chartOrders"></canvas>
  </div>
</div> --}}
<!-- .content -->

<!-- chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
  let configSales = {
    type: "line",
    data: {
      labels: ["1日", "2日", "3日", "4日", "5日", "6日", "7日"],
      datasets: [
        {
          label: "売上",
          data: [100000, 100000, 120000, 130000, 140000, 140000, 160000],
          borderColor: "#FB4B1B",
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
    },
  };

  let configOrders = {
    type: "line",
    data: {
      labels: ["1日", "2日", "3日", "4日", "5日", "6日", "7日"],
      datasets: [
        {
          label: "注文数",
          data: [90, 90, 110, 120, 130, 130, 150],
          borderColor: "#FB4B1B",
          backgroundColor: "rgba(0, 0, 0, 0)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
    },
  };

  window.onload = function () {
    let chartSales = document.getElementById("chartSales").getContext("2d");
    window.myLine = new Chart(chartSales, configSales);

    let chartOrders = document.getElementById("chartOrders").getContext("2d");
    window.myLine = new Chart(chartOrders, configOrders);
  };
</script>
@endsection