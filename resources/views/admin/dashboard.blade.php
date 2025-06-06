@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Dashboard -->
    <div class="row">
      <div class="col-xxl-8 mb-6 order-0">
        <div class="card">
          <div class="d-flex align-items-start row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary mb-3">Selamat Datang Admin! 👋</h5>
                <p class="mb-6">
                  Sistem Manajemen Perbaikan Fasilitas.<br />Pantau dan kelola semua laporan kerusakan dengan mudah.
                </p>
                <a href="{{ route('admin.data.laporan') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Laporan</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-6">
                <img
                  src="{{ asset('assets/img/illustrations/man-with-laptop.png') }}"
                  height="175"
                  alt="Admin Dashboard" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-6 mb-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                      alt="Total Laporan"
                      class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt3"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false">
                      <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      <a class="dropdown-item" href="{{ route('admin.data.laporan') }}">Lihat Semua</a>
                    </div>
                  </div>
                </div>
                <p class="mb-1">Total Laporan</p>
                <h4 class="card-title mb-3">{{ array_sum($statusCounts) }}</h4>
                <small class="text-success fw-medium"
                  ><i class="icon-base bx bx-up-arrow-alt"></i> Tahun {{ $currentYear }}</small
                >
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-6 mb-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between mb-4">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                      alt="Teknisi"
                      class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt6"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false">
                      <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                      <a class="dropdown-item" href="{{ route('data.user') }}">Lihat Semua</a>
                    </div>
                  </div>
                </div>
                <p class="mb-1">Total Teknisi</p>
                <h4 class="card-title mb-3">{{ $teknisi->count() }}</h4>
                <small class="text-success fw-medium"
                  ><i class="icon-base bx bx-user-plus"></i> Aktif</small
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart Total Perbaikan -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="m-0 me-2">Total Perbaikan Tahun {{ $currentYear }}</h5>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="totalRevenue"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalRevenue">
                <a class="dropdown-item" href="{{ route('admin.data.laporan') }}">Lihat Semua</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="refreshChart()">Refresh</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="TotalPerbaikanChart" style="height: 350px;"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card Growth -->
    <div class="row">
      @php
        $labels = ['Gedung', 'Ruang', 'Fasum'];
        $values = [$totalGedung, $totalRuang, $totalFasum];
        $maxValues = [100, 150, 200]; // Nilai maksimal untuk persentase
        $progress = [];
        for ($i = 0; $i < 3; $i++) {
          $progress[$i] = min(100, round(($values[$i] / $maxValues[$i]) * 100));
        }
      @endphp

      @for ($i = 0; $i < 3; $i++)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body d-flex align-items-center flex-column py-4">
            <!-- Dropdown Tahun -->
            <div class="text-center mb-3">
              <div class="btn-group">
                <button type="button" class="btn btn-outline-primary">{{ $currentYear }}</button>
                <button
                  type="button"
                  class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">{{ $currentYear - 1 }}</a></li>
                  <li><a class="dropdown-item" href="#">{{ $currentYear - 2 }}</a></li>
                </ul>
              </div>
            </div>

            <!-- Radial Chart -->
            <div id="growthChart{{ $i+1 }}" class="mb-3"></div>

            <!-- Label -->
            <h6 class="mb-0">{{ $values[$i] }} {{ $labels[$i] }}</h6>
            <small class="text-muted">{{ $progress[$i] }}% dari target</small>
          </div>
        </div>
      </div>
      @endfor
    </div>

    <!-- Status Laporan dan Laporan Terbaru -->
    <div class="row">
      <!-- Status Laporan -->
      <div class="col-md-6 col-lg-4 order-0 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
              <h5 class="mb-1 me-2">Status Laporan</h5>
              <p class="card-subtitle">{{ array_sum($statusCounts) }} Total Laporan</p>
            </div>
            <div class="dropdown">
              <button
                class="btn text-body-secondary p-0"
                type="button"
                id="orederStatistics"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                <a class="dropdown-item" href="{{ route('admin.data.laporan') }}">Lihat Semua</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-6">
              <div class="d-flex flex-column align-items-center gap-1">
                <h3 class="mb-1">{{ array_sum($statusCounts) }}</h3>
                <small>Total Laporan</small>
              </div>
              <div id="statusLaporanChart"></div>
            </div>
            <ul class="p-0 m-0">
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary"
                    ><i class="icon-base bx bx-check-circle"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Selesai</h6>
                    <small>Laporan yang sudah diperbaiki</small>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $statusCounts['selesai'] ?? 0 }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-warning"
                    ><i class="icon-base bx bx-time"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Proses</h6>
                    <small>Laporan dalam penanganan</small>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $statusCounts['proses'] ?? 0 }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-5">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-danger"
                    ><i class="icon-base bx bx-error"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Menunggu</h6>
                    <small>Laporan belum ditangani</small>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $statusCounts['menunggu'] ?? 0 }}</h6>
                  </div>
                </div>
              </li>
              <li class="d-flex align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info"
                    ><i class="icon-base bx bx-x-circle"></i
                  ></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Ditolak</h6>
                    <small>Laporan tidak valid</small>
                  </div>
                  <div class="user-progress">
                    <h6 class="mb-0">{{ $statusCounts['ditolak'] ?? 0 }}</h6>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Laporan Terbaru -->
      <div class="col-md-6 col-lg-8 order-1 mb-6">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Laporan Terbaru</h5>
            <div class="dropdown">
              <button
                class="btn text-body-secondary p-0"
                type="button"
                id="transactionID"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                <a class="dropdown-item" href="{{ route('admin.data.laporan') }}">Lihat Semua</a>
              </div>
            </div>
          </div>
          <div class="card-body pt-4">
            <ul class="p-0 m-0">
              @foreach($recentReports as $report)
              <li class="d-flex align-items-center mb-6">
                <div class="avatar flex-shrink-0 me-3">
                  11
                  {{-- <span class="avatar-initial rounded bg-label-{{ $this->getStatusColor($report->status_laporan) }}">
                    <i class="icon-base bx bx-{{ $this->getStatusIcon($report->status_laporan) }}"></i>
                  </span> --}}
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    22
                    {{-- <small class="d-block">{{ $report->kerusakan->ruang->gedung->nama }} - {{ $report->kerusakan->ruang->nama }}</small> --}}
                    <h6 class="fw-normal mb-0">{{ Str::limit($report->kerusakan->deskripsi_kerusakan, 40) }}</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-2">
                    33
                    {{-- <span class="badge bg-label-{{ $this->getStatusColor($report->status_laporan) }}">
                      {{ ucfirst($report->status_laporan) }}
                    </span> --}}
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Chart Total Perbaikan
  document.addEventListener('DOMContentLoaded', function() {
    const monthlyData = @json(array_values($monthlyData));
    
    const totalPerbaikanChart = new ApexCharts(document.getElementById("TotalPerbaikanChart"), {
      series: [{
        name: 'Total Perbaikan',
        data: monthlyData
      }],
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: true
        }
      },
      colors: ['#7367F0'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 2
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val + " laporan"
          }
        }
      }
    });
    totalPerbaikanChart.render();

    // Chart Status Laporan
    const statusCounts = @json($statusCounts);
    const statusLaporanChart = new ApexCharts(document.getElementById("statusLaporanChart"), {
      series: Object.values(statusCounts),
      chart: {
        type: 'donut',
        height: 150,
        width: 150
      },
      labels: Object.keys(statusCounts).map(label => label.charAt(0).toUpperCase() + label.slice(1)),
      colors: ['#28C76F', '#FF9F43', '#EA5455', '#00CFE8'],
      legend: {
        show: false
      },
      plotOptions: {
        pie: {
          donut: {
            size: '75%'
          }
        }
      }
    });
    statusLaporanChart.render();

    // Chart Growth (3 card)
    @for ($i = 0; $i < 3; $i++)
    const growthChart{{ $i+1 }} = new ApexCharts(document.getElementById("growthChart{{ $i+1 }}"), {
      series: [{{ $progress[$i] }}],
      chart: {
        height: 100,
        width: 100,
        type: 'radialBar',
      },
      plotOptions: {
        radialBar: {
          hollow: {
            size: '55%',
          },
          dataLabels: {
            name: {
              show: false,
            },
            value: {
              offsetY: 5,
              fontSize: '14px',
              fontWeight: '600',
              show: true,
              formatter: function(val) {
                return val + '%';
              }
            }
          }
        }
      },
      colors: ['#7367F0'],
      stroke: {
        lineCap: 'round'
      }
    });
    growthChart{{ $i+1 }}.render();
    @endfor
  });

  function refreshChart() {
    location.reload();
  }
</script>
@endpush

@push('styles')
<style>
  .avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .bg-label-primary { background-color: rgba(115,103,240,.12); color: #7367F0; }
  .bg-label-warning { background-color: rgba(255,159,67,.12); color: #FF9F43; }
  .bg-label-danger { background-color: rgba(234,84,85,.12); color: #EA5455; }
  .bg-label-info { background-color: rgba(0,207,232,.12); color: #00CFE8; }
  .bg-label-success { background-color: rgba(40,199,111,.12); color: #28C76F; }
</style>
@endpush

@endsection