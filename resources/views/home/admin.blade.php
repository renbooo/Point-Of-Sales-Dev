@extends('layouts.app')

@section('content-header')
  Dashboard
@endsection

@section('content') 
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-boxes"></i>
          </div>
          <div class="card-wrap">
              <div class="card-header">
                <h4>Total Kategori</h4>
              </div>
          </div>
          <div class="card-body">
            {{ $category }}
          </div>   
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-boxes"></i>
          </div>
          <div class="card-wrap">
              <div class="card-header">
                <h4>Total Produk</h4>
              </div>
          </div>
          <div class="card-body">
            {{ $product }}
          </div>   
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-boxes"></i>
          </div>
          <div class="card-wrap">
              <div class="card-header">
                <h4>Total Supplier</h4>
              </div>
          </div>
          <div class="card-body">
            {{ $supplier }}
          </div>   
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-boxes"></i>
          </div>
          <div class="card-wrap">
              <div class="card-header">
                <h4>Total Member</h4>
              </div>
          </div>
          <div class="card-body">
            {{ $member }}
          </div>   
        </div>
      </div>
</div>

    <div class="row">
              <div class="card">
                <div class="card-header">
              <h4>Grafik Pendapatan {{ indo_date($begin) }} - {{ indo_date($end) }}</h4>
            </div>
            <div class="card-body">
              <div class="chart">
            <canvas id="salesChart" height="400" width="1000"></canvas>
              </div>
            </div>
{{--             <div class="card-body">
              <div class="chart">
                    <canvas id="salesChart" style="height: 250px;"></canvas>
                </div>
            </div> --}}
        </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
var ctx = $("#salesChart").get(0).getContext("2d");
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: {{ json_encode($data_date) }},
        datasets: [{
            label: 'Pendapatan',
            backgroundColor: 'transparent',
            borderColor: '#d71149',
            data: {{ json_encode($data_income) }}
        }]
    },

    // Configuration options go here
    options: {
      pointDot: false,
      responsive: true}
});
// $(function () {
//   var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
//   var salesChart = new Chart(salesChartCanvas);

//   var salesChartData = {
//     labels: ,
//     datasets: [
//       {
//         label: "Electronics",
//         backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//         fillColor: "rgba(60,141,188,0.9)",
//         strokeColor: "rgb(210, 214, 222)",
//         pointColor: "rgb(210, 214, 222)",
//         pointStrokeColor: "#c1c7d1",
//         pointHighlightFill: "#fff",
//         pointHighlightStroke: "rgb(220,220,220)",
//         data: 
//       }
//     ]
//   };

//   var salesChartOptions = {
//     pointDot: false,
//     responsive: true
//   };

//   //Create the line chart
//   salesChart.Line(salesChartData, salesChartOptions);
// });
</script>
@endsection