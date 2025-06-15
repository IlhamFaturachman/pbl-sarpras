@extends('layouts.app')

@section('content')
    <!-- Dashboard Section -->
    <div class="row">
        <!-- Kolom Kiri: Selamat Datang -->
        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Selamat Datang {{ Auth::user()->nama }}! 👋</h5>
                            <p class="mb-6">
                                Sistem Manajemen Perbaikan Fasilitas.<br />
                                Kelola laporan kerusakan sekarang
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                            <img src="{{ asset('assets/img/illustrations/student.png') }}" height="175"
                                alt="Sarpras Dashboard" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Total Teknisi -->
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="Teknisi"
                            class="rounded" width="40" />
                    </div>
                    <h6 class="card-title">Total Teknisi</h6>
                    <h4 class="card-title mb-3">{{ $teknisi->count() }}</h4>
                    <small class="text-success fw-medium"><i class="icon-base bx bx-user-plus"></i> Aktif</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Summary Cards -->
    <div class="row">
        <!-- Card: Verifikasi Laporan -->
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-check-fill text-success fs-2"></i>
                    </div>
                    <h6 class="card-title">Verifikasi Laporan</h6>
                    <p class="mb-1">Belum Disetujui: <strong>{{ $verifikasiBelum }}</strong></p>
                    <p>Disetujui: <strong>{{ $verifikasiSudah }}</strong></p>
                    <a href="{{ route('laporan.verifikasi') }}" class="btn btn-sm btn-outline-primary">Verifikasi Laporan</a>
                </div>
            </div>
        </div>

        <!-- Card: Penugasan Teknisi -->
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-wrench-adjustable-circle text-warning fs-2"></i>
                    </div>
                    <h6 class="card-title">Penugasan Teknisi</h6>
                    <p class="mb-1">Belum Ditugaskan: <strong>{{ $penugasanBelum }}</strong></p>
                    <p>Sudah Ditugaskan: <strong>{{ $penugasanSudah }}</strong></p>
                    <a href="{{ route('laporan.penugasan') }}" class="btn btn-sm btn-outline-primary">Tugaskan Teknisi</a>
                </div>
            </div>
        </div>

        <!-- Card: Riwayat Laporan -->
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-clock-history text-secondary fs-2"></i>
                    </div>
                    <h6 class="card-title">Riwayat Laporan</h6>
                    <p class="mb-1">Selesai: <strong>{{ $riwayatSelesai }}</strong></p>
                    <p>Ditolak: <strong>{{ $riwayatTolak }}</strong></p>
                    <a href="{{ route('laporan.riwayat') }}" class="btn btn-sm btn-outline-primary">Lihat Riwayat</a>
                </div>
            </div>
        </div>
    </div>
@endsection
