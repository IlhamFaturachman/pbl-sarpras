@extends('layouts.app')

@section('content')
<div class="container px-4 py-4">
  <div class="row g-4">
    <!-- Kolom Kiri: Selamat Datang -->
    <div class="col-md-6">
      <div class="card h-100">
        <div class="row g-0 align-items-center">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary mb-3">Selamat Datang {{ Auth::user()->nama }}! 👋</h5>
              <p class="mb-0">
                Sistem Manajemen Perbaikan Fasilitas.<br />
                Kerjakan perbaikan fasilitas yang ditugaskan!
              </p>
            </div>
          </div>
          <div class="col-sm-5 text-center">
            <div class="card-body pb-0 px-0">
              <img src="{{ asset('assets/img/illustrations/technician.png') }}" height="130" alt="Teknisi Dashboard" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: 3 Statistik Card Horizontal -->
    <div class="col-md-6">
      <div class="d-flex justify-content-between gap-2 h-100">
        <!-- Card 1 -->
        <div class="card text-center flex-fill d-flex flex-column justify-content-center align-items-center" style="flex: 1;">
          <div class="card-body p-2">
            <img src="{{ asset('assets/img/icons/unicons/task.png') }}" alt="Tanggungan" width="30" class="mb-2" />
            <h6 class="card-title small mb-1">Tanggungan Perbaikan</h6>
            <h5>{{ $tanggunganPerbaikan }}</h5>
            <a href="{{ route('penugasan') }}" class="btn btn-sm btn-outline-primary mt-2">Kerjakan</a>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="card text-center flex-fill d-flex flex-column justify-content-center align-items-center" style="flex: 1;">
          <div class="card-body p-2">
            <img src="{{ asset('assets/img/icons/unicons/task-done.png') }}" alt="Selesai" width="30" class="mb-2" />
            <h6 class="card-title small mb-1">Perbaikan Selesai</h6>
            <h5>{{ $totalPerbaikan }}</h5>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="card text-center flex-fill d-flex flex-column justify-content-center align-items-center" style="flex: 1;">
          <div class="card-body p-2">
            <img src="{{ asset('assets/img/icons/unicons/rate.png') }}" alt="Rating" width="30" class="mb-2" />
            <h6 class="card-title small mb-1">Rata-rata Rating</h6>
            <h5>{{ number_format($averageRating, 1) }}/5</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="card mt-4">
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