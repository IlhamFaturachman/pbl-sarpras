@extends('layouts.app')

@section('content')
<!-- Dashboard Section -->
<div class="row">
  <!-- Kolom Kiri: Selamat Datang -->
  <div class="col-xl-8 col-lg-12 mb-4">
    <div class="card h-100">
      <div class="d-flex align-items-start row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary mb-3">Selamat Datang {{ Auth::user()->nama }}!👋</h5>
            <p class="mb-6">
              Sistem Manajemen Perbaikan Fasilitas.<br />
              Laporkan kerusakan sarana agar perkuliahan menjadi lebih aman dan nyaman
            </p>
            <a href="{{ route('users.kerusakan') }}" class="btn btn-sm btn-outline-primary">Buat Laporan Sekarang</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{ asset('assets/img/illustrations/student.png') }}" height="175" alt="Admin Dashboard" />
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Kolom Kanan: Total Laporan -->
    <div class="col-xl-4 col-lg-12 mb-4">
    @if($totalLaporan > 0)
    <div class="card h-100">
        <div class="card-body py-4 d-flex flex-column justify-content-center">
        <div class="d-flex justify-content-between align-items-center">
            <div>
            <h5 class="card-title mb-2 text-muted" style="font-size: 1.1rem;">Total Laporan Saya</h5>
            <h2 class="mb-1 text-primary fw-bold" style="font-size: 2.5rem;">{{ $totalLaporan }}</h2>
            <small class="text-muted" style="font-size: 0.95rem;">Semua laporan yang dibuat</small>
            </div>
            <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bx bx-clipboard fs-2"></i>
            </span>
            </div>
        </div>
        </div>
    </div>
    @endif
    </div>


  <!-- Baris Baru: Status Laporan -->
  <div class="col-12 mb-4">
    @if($totalLaporan > 0)
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4" style="font-size: 1.2rem;">Status Laporan</h5>
        <div class="row text-center">
          <div class="col-4">
            <div class="mb-3">
                <span class="badge bg-label-info" style="font-size: 1.4rem; padding: 0.6rem 1rem;">{{ $laporanDiajukan }}</span>
            </div>
            <span style="font-size: 1rem;" class="text-muted">Diajukan</span>
          </div>
          <div class="col-4">
            <div class="mb-3">
                <span class="badge bg-label-primary" style="font-size: 1.4rem; padding: 0.6rem 1rem;">{{ $laporanDisetujui }}</span>
            </div>
            <span style="font-size: 1rem;" class="text-muted">Disetujui</span>
          </div>
          <div class="col-4">
            <div class="mb-2">
                <span class="badge bg-label-danger" style="font-size: 1.4rem; padding: 0.6rem 1rem;">{{ $laporanDitolak }}</span>
            </div>
            <span style="font-size: 1rem;" class="text-muted">Ditolak</span>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>


<!-- Card Laporan Terbaru -->
<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Laporan Terbaru</h5>
        <a href="{{ route('users.kerusakan') }}" class="btn btn-sm btn-outline-primary">
          Lihat Semua
        </a>
      </div>
      <div class="card-body">
        @if(isset($laporanTerbaru) && $laporanTerbaru->count() > 0)
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Fasilitas</th>
                <th>Lokasi</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($laporanTerbaru as $laporan)
              <tr>
                <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d/m/Y') }}</td>
                <td>{{ $laporan->kerusakan->item->nama ?? '-' }}</td>
                <td>
                  @if ($laporan->kerusakan->item->ruang)
                    {{ $laporan->kerusakan->item->ruang->nama }}
                  @elseif ($laporan->kerusakan->item->fasum)
                    {{ $laporan->kerusakan->item->fasum->nama }}
                  @else
                    -
                  @endif
                </td>
                <td>
                  @switch($laporan->status_laporan)
                    @case('Diajukan') <span class="badge bg-warning">Diajukan</span> @break
                    @case('Disetujui') <span class="badge bg-info">Disetujui</span> @break
                    @case('Ditolak') <span class="badge bg-danger">Ditolak</span> @break
                    @case('Dikerjakan') <span class="badge bg-primary">Dikerjakan</span> @break
                    @case('Selesai') <span class="badge bg-success">Selesai</span> @break
                  @endswitch
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="text-center text-muted py-4">
          <i class="bx bx-clipboard bx-lg mb-2"></i>
          <p class="mb-0">Belum ada laporan</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
