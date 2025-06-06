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
        <h5 class="mb-0">Data Laporan Kerusakan</h5>
        <a href="{{ route('admin.laporan.export_pdf') }}" class="btn btn-warning"><i class="fa fa-filepdf"></i> Export PDF</a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">ID Laporan</th>
                    <th style="font-weight: bold;">Nama Pelapor</th>
                    <th style="font-weight: bold;">Fasilitas</th>
                    <th style="font-weight: bold;">Item</th>
                    <th style="font-weight: bold;">Tanggal Dilaporkan</th>
                    <th style="font-weight: bold;"  class="text-center">Status</th>
                    <th class="text-center" style="font-weight: bold;">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($laporans as $laporan)
                    <tr>
                        <td>{{ $laporan->laporan_id }}</td>
                        <td>{{ $laporan->kerusakan->pelapor->nama_lengkap }}</td>
                        @if ($laporan->kerusakan->item->fasum_id == null)
                            <td>{{ Str::limit($laporan->kerusakan->item->ruang->gedung->nama, 30, '...') }}</td>
                        @else 
                            <td>{{ $laporan->kerusakan->item->fasum->nama }}</td>
                        @endif
                        <td>{{ $laporan->kerusakan->item->nama }}</td>
                        <td>{{ $laporan->tanggal_laporan }}</td>
                        <td class="text-center">
                            @if ($laporan->status_laporan == 'Diajukan')
                                <span style="background-color: #fcefdc; color: #9c6b1a; padding: 6px 12px; border-radius: 8px; display: inline-block; width: 100px; text-align: center;">
                                    Diajukan
                                </span>
                            @elseif ($laporan->status_laporan == 'Disetujui')
                                <span style="background-color: #e3f2fd; color: #007bff; padding: 6px 12px; border-radius: 8px; display: inline-block; width: 100px; text-align: center;">
                                    Disetujui
                                </span>
                            @elseif ($laporan->status_laporan == 'Dikerjakan')
                                <span style="background-color: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 8px; display: inline-block; width: 100px; text-align: center;">
                                    Dikerjakan
                                </span>
                            @elseif ($laporan->status_laporan == 'Selesai')
                                <span style="background-color: #d4edda; color: #155724; padding: 6px 12px; border-radius: 8px; display: inline-block; width: 100px; text-align: center;">
                                    Selesai
                                </span>
                            @elseif ($laporan->status_laporan == 'Ditolak')
                                <span style="background-color: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 8px; display: inline-block; width: 100px; text-align: center;">
                                    Ditolak
                                </span>
                            @else
                                <span style="display: inline-block; width: 100px; text-align: center;">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary detail-laporan" data-id="{{ $laporan->laporan_id }}">Detail</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($laporans->hasPages())
            <x-pagination :paginator="$laporans" />
        @endif
    </div>
    
</div>
@include('admin.laporan.show')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Flash messages
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

    // Event handler untuk tombol detail - gunakan event delegation
    $(document).on('click', '.detail-laporan', function(e) {
        e.preventDefault();
        
        const laporanId = $(this).data('id');
        
        // Tampilkan loading
        Swal.fire({
            title: 'Memuat...',
            text: 'Mengambil detail laporan',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: "{{ url('admin/laporan') }}/" + laporanId + "/show",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                
                // Tutup loading
                Swal.close();
                
                const laporan = response.laporan || {};
                const penugasan = response.penugasan || {};
                const kerusakan = laporan.kerusakan || {};
                const teknisi = penugasan.teknisi || {};

                console.log('Response data:', response);
                console.log('Kerusakan data:', kerusakan);
                console.log('verifikator:', laporan.verifikator_id);
                console.log('Ruang data:', kerusakan.ruang);
                console.log('Fasum data:', kerusakan.fasum);

                // Function untuk format tanggal
                function formatTanggalDMY(tanggal) {
                    if (!tanggal) return '-';
                    const [year, month, day] = tanggal.split('-');
                    return `${day}-${month}-${year}`;
                }

                // Function untuk render status laporan badge
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

                // Function untuk render status perbaikan badge
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

                // Set status laporan
                const status_laporan = laporan.status_laporan ?? '-';
                $('#status_laporan').html(renderStatusLaporanBadge(status_laporan));

                // Set data laporan
                $('#detail_tanggal_laporan').text(formatTanggalDMY(laporan.tanggal_laporan));
                
                // Lokasi Fasilitas
                let lokasi = '-';
                if (kerusakan.item && kerusakan.item.ruang_id && kerusakan.item.ruang) {
                    // Jika ada ruang dan gedung
                    const gedungNama = kerusakan.item.ruang.gedung?.nama || 'Gedung Tidak Diketahui';
                    lokasi = `${kerusakan.item.ruang.nama}, ${gedungNama}`;
                } else if (kerusakan.item && kerusakan.item.fasum_id && kerusakan.item.fasum) {
                    // Jika ada fasum
                    lokasi = kerusakan.item.fasum.nama;
                } else if (kerusakan.item) {
                    // Fallback ke nama item saja
                    lokasi = kerusakan.item.nama;
                }

                $('#detail_lokasi_fasilitas').text(lokasi);
                
                $('#detail_item').text(kerusakan.item?.nama ?? '-');
                $('#detail_deskripsi_kerusakan').text(kerusakan.deskripsi_kerusakan ?? '-');
                $('#detail_pelapor').text(kerusakan.pelapor?.nama_lengkap ?? '-');
                $('#detail_verifikator').text(laporan.verifikator?.nama_lengkap ?? '-');

                // Set foto kerusakan
                if(laporan.kerusakan?.foto_kerusakan) {
                    $('#detail_foto_kerusakan').attr('src', '/storage/' + laporan.kerusakan.foto_kerusakan);
                    $('#detail_foto_kerusakan').show();
                } else {
                    $('#detail_foto_kerusakan').hide();
                }

                // Set status penugasan
                const status_perbaikan = penugasan.status_penugasan ?? '-';
                $('#status_penugasan').html(renderStatusPerbaikanBadge(status_perbaikan));

                // Set data penugasan
                $('#detail_tanggal_mulai').text(formatTanggalDMY(penugasan.tanggal_mulai));
                $('#detail_tanggal_selesai').text(formatTanggalDMY(penugasan.tanggal_selesai));
                $('#detail_teknisi').text(teknisi?.nama_lengkap ?? '-');
                $('#detail_catatan_perbaikan').text(penugasan.catatan_perbaikan ?? '-');

                // Set bukti perbaikan
                if(penugasan.bukti_perbaikan) {
                    $('#detail_bukti_perbaikan').attr('src', '/storage/' + penugasan.bukti_perbaikan);
                    $('#detail_bukti_perbaikan').show();
                } else {
                    $('#detail_bukti_perbaikan').hide();
                }

                // Tampilkan modal - PASTIKAN ID MODAL BENAR
                $('#detailLaporanAdmin').modal('show'); // Sesuaikan dengan ID modal yang benar
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error); // Debug log
                console.error('Response:', xhr.responseText); // Debug log
                
                Swal.close();
                Swal.fire('Error', 'Gagal mengambil detail laporan: ' + error, 'error');
            }
        });
    });
});
</script>
@endsection