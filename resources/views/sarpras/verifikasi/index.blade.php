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
        <h5 class="mb-0">Data Verifikasi Laporan Kerusakan Fasilitas</h5>

        <div class="position-relative" style="max-width: 300px; width: 100%;">
            <i class="bi bi-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
            <input 
            type="text" 
            id="searchInput" 
            class="form-control form-control-sm" 
            placeholder="Cari..." 
            style="background-color: #f8f9fa; border: 1px solid #ced4da; color: #495057; font-weight: 400; font-size: 1rem; height: 42px; padding-left: 2.5rem;" />
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Tanggal Laporan</th>
                    <th style="font-weight: bold;">Nama Sarana</th>
                    <th style="font-weight: bold;">Lokasi Fasilitas</th>
                    <th style="font-weight: bold;" class="text-center">Status Laporan</th>
                    <th style="font-weight: bold;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $laporan)
                <tr>
                    <td>{{ $loop->iteration + ($laporans->firstItem() - 1) }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d-m-Y') }}</td>
                    <td>{{ $laporan->kerusakan->item->nama ?? '-' }}</td>
                    <td>{{ $laporan->kerusakan->item->ruang
                        ? $laporan->kerusakan->item->ruang->nama . ', ' . $laporan->kerusakan->item->ruang->gedung->nama
                        : ($laporan->kerusakan->item->fasum->nama ?? '-'); }}
                    </td>
                    <td class="text-center">
                        @switch($laporan->status_laporan)
                            @case('Diajukan')
                                <span style="background-color: #ffe8cc; color: #000; padding: 4px 8px; border-radius: 5px; display: inline-block; width: 100px;">Diajukan</span>
                            @break
                        @default
                            <span class="d-inline-block" style="width:100px;">-</span>
                        @endswitch
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-primary detail-laporan" style="width: 70px;" data-id="{{ $laporan->laporan_id }}">Detail</button>
                            <button class="btn btn-sm btn-success verifikasi-laporan" style="width: 70px;" data-id="{{ $laporan->laporan_id }}">Setujui</button>
                            <button type="button" class="btn btn-sm btn-danger" style="width: 70px;" onclick="showTolakModal('{{ $laporan->laporan_id }}')">Tolak</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada laporan yang perlu diverifikasi</td>
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

@include('sarpras.verifikasi.show')
@include('sarpras.verifikasi.prioritas')
@include('sarpras.verifikasi.tolak')

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        $('.detail-laporan').on('click', function() {
            const laporanId = $(this).data('id');
            $.ajax({
                url: "{{ url('sarpras/laporan/verifikasi') }}/" + laporanId + "/show",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const laporan = response.laporan || {};
                    const penugasan = response.penugasan || {};
                    const kerusakan = laporan.kerusakan || {};

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
                    if (kerusakan.item?.ruang?.nama && kerusakan.item?.ruang?.gedung?.nama) {
                        lokasi = `${kerusakan.item?.ruang.nama}, ${kerusakan.item?.ruang.gedung.nama}`;
                    } else if (kerusakan.item?.fasum?.nama) {
                        lokasi = kerusakan.item?.fasum.nama;
                    }

                    function formatTanggalDMY(tanggal) {
                        if (!tanggal) return '-';
                        const [year, month, day] = tanggal.split('-');
                        return `${day}-${month}-${year}`;
                    }

                    $('#detail_laporan_id').text(laporan.laporan_id);                    
                    $('#detail_tanggal_laporan').text(formatTanggalDMY(laporan.tanggal_laporan));
                    $('#detail_lokasi_fasilitas').text(lokasi);
                    $('#detail_item').text(kerusakan.item?.nama ?? '-');
                    $('#detail_deskripsi_kerusakan').text(kerusakan.deskripsi_kerusakan ?? '-');
                    $('#detail_pelapor').text(kerusakan.pelapor?.nama_lengkap ?? '-');

                    if (laporan.kerusakan.foto_kerusakan) {
                        $('#detail_foto_kerusakan').attr('src', '/storage/' + laporan.kerusakan.foto_kerusakan);
                    } else {
                        $('#detail_foto_kerusakan').attr('src', '');
                    }

                    // Tampilkan modal
                    $('#detailLaporan').modal('show');
                },
                error: function() {
                    Swal.fire('Error', 'Gagal mengambil detail laporan.', 'error');
                }
            });
        });

        function updateLabelAndPrioritas() {
            const kerusakan = parseInt($('#tingkat_kerusakan').val());
            const dampak = parseInt($('#tingkat_dampak').val());
            const terdampak = parseInt($('#jumlah_terdampak').val());
            const alternatif = parseInt($('input[name="alternatif"]:checked').val());
            const keamanan = parseInt($('#keamanan').val());

            $('#val_kerusakan').text(kerusakan);
            $('#val_dampak').text(dampak);
            $('#val_terdampak').text(terdampak);
            $('#val_alternatif').text(alternatif === 0 ? 'Ada' : 'Tidak Ada');
            $('#val_keamanan').text(keamanan);
        }

        $('#tingkat_kerusakan, #tingkat_dampak, #jumlah_terdampak, #keamanan').on('input', updateLabelAndPrioritas);
        $('input[name="alternatif"]').on('change', updateLabelAndPrioritas);

        $('.verifikasi-laporan').on('click', function () {
            const laporanId = $(this).data('id');
            $('#btnSimpanPrioritas').data('id', laporanId);
            $('#prioritasModal').modal('show');
            updateLabelAndPrioritas();
        });

        $('#btnSimpanPrioritas').on('click', function () {
            const laporanId = $(this).data('id');

            const kerusakan = parseInt($('#tingkat_kerusakan').val());
            const dampak = parseInt($('#tingkat_dampak').val());
            const terdampak = parseInt($('#jumlah_terdampak').val());
            const alternatif = parseInt($('input[name="alternatif"]:checked').val());
            const keamanan = parseInt($('#keamanan').val());

            $.ajax({
                url: "{{ url('sarpras/laporan/verifikasi') }}" + '/' + laporanId + '/prioritas',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    tingkat_kerusakan: kerusakan,
                    dampak: dampak,
                    jumlah_terdampak: terdampak,
                    alternatif: alternatif,
                    ancaman: keamanan
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Skor Prioritas: ' + response.skor_laporan + '\n' + response.message,
                        icon: 'success',
                        showConfirmButton: true
                    }).then(() => {
                        location.reload();
                    });

                    $('#prioritasModal').modal('hide');
                },
                error: function (xhr) {
                    let msg = "Terjadi kesalahan saat menyimpan prioritas.";
                    if (xhr.responseJSON?.error) msg = xhr.responseJSON.error;

                    Swal.fire({
                        title: "Error",
                        text: msg,
                        icon: "error"
                    });
                }
            });
        });

         // Search input filtering
        $('#searchInput').on('keyup', function () {
            const keyword = $(this).val().toLowerCase().trim();
            
            $('table tbody tr').each(function () {
                // Cek semua kolom di baris ini
                const rowText = $(this).text().toLowerCase();
                
                if (rowText.indexOf(keyword) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

@endsection