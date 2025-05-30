@extends('layouts.app')

@section('content')
<div class="container px-4 py-4">

  <!-- 3 Cards -->
  <div class="row mb-4">
    <div class="col-12 col-md-4 mb-3 mb-md-0">
      <div class="card text-center h-100">
        <div class="card-body d-flex flex-column justify-content-center">
          <h5 class="card-title">Total Tanggungan Perbaikan</h5>
          <h2>{{ $tanggunganPerbaikan }}</h2>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4 mb-3 mb-md-0">
      <div class="card text-center h-100">
        <div class="card-body d-flex flex-column justify-content-center">
          <h5 class="card-title">Total Perbaikan Selesai</h5>
          <h2>{{ $totalPerbaikan }}</h2>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card text-center h-100">
        <div class="card-body d-flex flex-column justify-content-center">
          <h5 class="card-title">Rata-rata Rating Perbaikan</h5>
          <h2>{{ number_format($averageRating, 1) }}/5</h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Section inside a card -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Grafik Penyelesaian Perbaikan per Periode</h5>
      <div id="chart"></div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
    var options = {
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 6,
                columnWidth: '50%'
            }
        },
        colors: ['#6074ff', '#00c1e8'],
        series: [{
            name: 'Total Perbaikan Selesai',
            data: @json($chartData)
        }],
        xaxis: {
            categories: @json($chartLabels),
            title: { 
              text: 'Periode',
              style: {
                fontSize: '14px',
                fontWeight: '500',
                color: '#333'
              }
             }
        },
        yaxis: {
            min: 0,
            max: 10,
            tickAmount: 5,
            title: { 
              text: 'Jumlah',
              style: {
                fontSize: '14px',
                fontWeight: '500',
                color: '#333'
              }
             }
        },
        dataLabels: {
            enabled: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endsection
