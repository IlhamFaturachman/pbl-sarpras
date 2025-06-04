@extends('layouts.app')

@section('content')

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Riwayat Laporan Perbaikan Fasilitas</h5>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Tanggal Laporan</th>
                    <th style="font-weight: bold;">Nama Fasilitas</th>
                    <th style="font-weight: bold;">Lokasi Fasilitas</th>
                    <th style="font-weight: bold;" class="text-center">Status Laporan</th>
                    <th style="font-weight: bold;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $laporan)
                    @php
                        $kerusakan = $laporan->kerusakan;
                        $penugasan = $laporan->penugasan;
                        $lokasi = $kerusakan->ruang 
                                    ? $kerusakan->ruang->nama . ', ' . $kerusakan->ruang->gedung->nama 
                                    : ($kerusakan->fasum->nama ?? '-');
                        $statusLaporan = $laporan->status_laporan ?? null;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration + ($laporans->firstItem() - 1) }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d-m-y') }}</td>
                        <td>{{ $kerusakan->item->nama ?? '-' }}</td>
                        <td>{{ $lokasi }}</td>
                        <td class="text-center">
                            @switch($statusLaporan)       
                                @case('Selesai')
                                    <span style="background-color: #d3f9d8; color: #37b24d; padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px;">Selesai</span>
                                    @break
                                @case('Ditolak')
                                    <span style="background-color: #ffe3e3; color: #f03e3e; padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px;">Ditolak</span>
                                    @break
                                @default
                                    <span class="d-inline-block" style="width:100px;">-</span>
                            @endswitch
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-primary detail-laporan" data-id="{{ $laporan->laporan_id }}">Detail</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data laporan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3 me-3">
        {{ $laporans->links() }}
    </div>
</div>

@include('sarpras.riwayat.show')

<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                title: "Berhasil",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: "Gagal",
                text: "{{ session('error') }}",
                icon: "error"
            });
        @endif
        
        // Handle detail button on click
        $('.detail-laporan').on('click', function () {
            const laporanId = $(this).data('id');
            $.ajax({
                url: "{{ url('sarpras/laporan/riwayat') }}/" + laporanId + "/show",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const laporan = response.laporan || {};
                    const penugasan = response.penugasan || {};
                    const kerusakan = laporan.kerusakan || {};
                    const teknisi = penugasan.teknisi || {};
                    const feedback = laporan.feedback || {};

                    // Set status_laporan dengan badge warna
                    const status_laporan = laporan.status_laporan ?? '-';
                    function renderStatusLaporanBadge(status_laporan) {
                        const baseStyle = "padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px; text-align: center; font-weight: bold;";
                        switch (status_laporan) {
                            case 'Diajukan':
                                return `<span style="background-color: #ffe8cc; color: #000; ${baseStyle}">Diajukan</span>`;
                            case 'Disetujui':
                                return `<span style="background-color: #d0ebff; color: #1c7ed6; ${baseStyle}">Disetujui</span>`;
                            case 'Dikerjakan':
                                return `<span style="background-color: #fff3bf; color: #f59f00; ${baseStyle}">Dikerjakan</span>`;
                            case 'Selesai':
                                return `<span style="background-color: #d3f9d8; color: #37b24d; ${baseStyle}">Selesai</span>`;
                            case 'Ditolak':
                                return `<span style="background-color: #ffe3e3; color: #f03e3e; ${baseStyle}">Ditolak</span>`;
                            default:
                                return `<span style="display: inline-block; width: 100px; text-align: center;">-</span>`;
                        }
                    }
                    $('#status_laporan').html(renderStatusLaporanBadge(status_laporan));

                    // Lokasi Fasilitas
                    let lokasi = '-';
                    if (kerusakan.ruang?.nama && kerusakan.ruang?.gedung?.nama) {
                        lokasi = `${kerusakan.ruang.nama}, ${kerusakan.ruang.gedung.nama}`;
                    } else if (kerusakan.fasum?.nama) {
                        lokasi = kerusakan.fasum.nama;
                    }
                    
                    function formatTanggalDMY(tanggal) {
                        if (!tanggal) return '-';
                        const [year, month, day] = tanggal.split('-');
                        return `${day}-${month}-${year}`;
                    }

                    $('#detail_tanggal_laporan').text(formatTanggalDMY(laporan.tanggal_laporan));
                    $('#detail_lokasi_fasilitas').text(lokasi);
                    $('#detail_item').text(kerusakan.item?.nama ?? '-');
                    $('#detail_deskripsi_kerusakan').text(kerusakan.deskripsi_kerusakan ?? '-');
                    $('#detail_pelapor').text(laporan.pelapor?.nama_lengkap ?? '-');

                    if(laporan.kerusakan.foto_kerusakan){
                        $('#detail_foto_kerusakan').attr('src', '/storage/' + laporan.kerusakan.foto_kerusakan);
                    } else {
                        $('#detail_foto_kerusakan').attr('src', '');
                    }

                    // Set status_penugasan dengan badge warna
                    const status_perbaikan = penugasan.status_penugasan ?? '-';

                    function renderStatusPerbaikanBadge(status_perbaikan) {
                        const baseStyle = "padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px; text-align: center;";
                        switch (status_perbaikan) {
                            case 'Progress':
                                return `<span style="color: #007bff; border: 1px solid #007bff; ${baseStyle}">Progress</span>`;
                            case 'Selesai':
                                return `<span style="color: #28a745; border: 1px solid #28a745; ${baseStyle}">Selesai</span>`;
                            case 'Revisi':
                                return `<span style="color: #dc3545; border: 1px solid #dc3545; ${baseStyle}">Revisi</span>`;
                            case 'Menunggu':
                                return `<span style="color: #ffc107; border: 1px solid #ffc107; ${baseStyle}">Menunggu</span>`;
                            default:
                                return `<span style="display: inline-block; width: 100px; text-align: center;">-</span>`;
                        }
                    }

                    $('#status_penugasan').html(renderStatusPerbaikanBadge(status_perbaikan));

                    function formatTanggalDMY(tanggal) {
                        if (!tanggal) return '-';
                        const [year, month, day] = tanggal.split('-');
                        return `${day}-${month}-${year}`;
                    }

                    $('#detail_tanggal_mulai').text(formatTanggalDMY(penugasan.tanggal_mulai));
                    $('#detail_tanggal_selesai').text(formatTanggalDMY(penugasan.tanggal_selesai));
                    $('#detail_teknisi').text(teknisi?.nama_lengkap ?? '-');
                    $('#detail_catatan_perbaikan').text(penugasan.catatan_perbaikan ?? '-');

                    if(penugasan.bukti_perbaikan){
                        $('#detail_bukti_perbaikan').attr('src', '/storage/' + penugasan.bukti_perbaikan);
                    } else {
                        $('#detail_bukti_perbaikan').attr('src', '');
                    }

                    $('#detail_komentar').text(feedback.komentar ?? '-');
                    $('#detail_rating').html(feedback.rating ? '⭐'.repeat(feedback.rating) + ` (${feedback.rating})` : '-');

                    // tampilkan/hidden bagian perbaikan & feedback
                    if (laporan.status_laporan === 'Ditolak') {
                    $('#card_perbaikan').hide();
                    $('#card_feedback').hide();
                    } else {
                    $('#card_perbaikan').show();
                    $('#card_feedback').show();
                    }

                    // Tampilkan modal
                    $('#detailLaporan').modal('show');
                },
                error: function () {
                    Swal.fire('Error', 'Gagal mengambil detail laporan.', 'error');
                }
            });
        });
    });
</script>

@endsection
