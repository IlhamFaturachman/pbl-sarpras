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
        <h5 class="mb-0">Data Verifikasi Laporan Perbaikan Fasilitas</h5>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Tanggal Laporan</th>
                    <th>Nama Fasilitas</th>
                    <th>Lokasi Fasilitas</th>
                    <th>Prioritas Laporan</th>
                    <th class="text-center">Status Laporan</th>
                    <th class="text-center">Actions</th>
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
                $status = $penugasan->status_penugasan ?? null;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d-m-y') }}</td>
                    <td>{{ $kerusakan->item->nama ?? '-' }}</td>
                    <td>{{ $lokasi }}</td>
                    <td>
                        @php
                        $skor = $laporan->prioritas->skor_laporan ?? null;
                        if (is_null($skor)) {
                        echo '-';
                        } elseif ($skor <= 40) {
                            echo "Rendah ($skor)" ;
                            } elseif ($skor <=70) {
                            echo "Sedang ($skor)" ;
                            } else {
                            echo "Tinggi ($skor)" ;
                            }
                            @endphp
                            </td>
                    <td class="text-center">
                        @switch($statusLaporan)
                        @case('Progress')
                        @case('Diajukan')
                        <span style="background-color: #ffe8cc; color: #000; ${baseStyle}">Diajukan</span>
                        @break
                        @default
                        <span class="d-inline-block" style="width:100px;">-</span>
                        @endswitch
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-primary detail-laporan" data-id="{{ $laporan->laporan_id }}">Detail</button>
                            <button class="btn btn-sm btn-success verifikasi-laporan" data-id="{{ $laporan->laporan_id }}">Verifikasi</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data laporan</td>
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
            const alternatif = parseInt($('#alternatif').val());
            const keamanan = parseInt($('#keamanan').val());

            $('#val_kerusakan').text(kerusakan);
            $('#val_dampak').text(dampak);
            $('#val_terdampak').text(terdampak);
            $('#val_alternatif').text(alternatif);
            $('#val_keamanan').text(keamanan);

            // Perhitungan sederhana prioritas: semakin besar nilai, semakin tinggi
            let prioritas = Math.round((kerusakan + dampak + terdampak + (100 - alternatif) + keamanan) / 5);

            let label = 'Rendah';
            if (prioritas >= 70) label = 'Tinggi';
            else if (prioritas >= 40) label = 'Sedang';

            $('#nilai_prioritas').text(`${label} (${prioritas})`);
        }

        $('#tingkat_kerusakan, #tingkat_dampak, #jumlah_terdampak, #alternatif, #keamanan').on('input', updateLabelAndPrioritas);


        $('.verifikasi-laporan').on('click', function() {
            $('#prioritasModal').modal('show');
            updateLabelAndPrioritas();
        });

        $('#btnSimpanPrioritas').on('click', function() {
            const laporanId = $('.verifikasi-laporan').data('id');

            $.ajax({
                url: "{{ url('sarpras/laporan/verifikasi') }}" + '/' + laporanId + '/prioritas',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    tingkat_kerusakan: $('#tingkat_kerusakan').val(),
                    dampak: $('#tingkat_dampak').val(),
                    jumlah_terdampak: $('#jumlah_terdampak').val(),
                    alternatif: $('#alternatif').val(),
                    ancaman: $('#keamanan').val(),
                    skor_laporan: Math.round((
                        parseInt($('#tingkat_kerusakan').val()) +
                        parseInt($('#tingkat_dampak').val()) +
                        parseInt($('#jumlah_terdampak').val()) +
                        (100 - parseInt($('#alternatif').val())) +
                        parseInt($('#keamanan').val())
                    ) / 5)
                },
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    $('#prioritasModal').modal('hide');
                },
                error: function(xhr) {
                    Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan prioritas.', 'error');
                }
            });
        });
    });
</script>

@endsection