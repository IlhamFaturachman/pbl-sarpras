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
        <h5 class="mb-0">Data Kerusakan Fasilitas</h5>
        <div class="d-flex gap-2">
            <a href="{{ url('/users/kerusakan/export_pdf') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-file-pdf me-1"></i> Export PDF
            </a>
            <button type="button" class="btn btn-primary" onclick="showCreateModal()">
                <i class="fas fa-plus me-2"></i>Tambah Kerusakan
            </button>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th><strong>No</strong></th>
                    <th><strong>Item</strong></th>
                    <th><strong>Lokasi Fasilitas</strong></th>
                    <th><strong>Deskripsi Kerusakan</strong></th>
                    <th><strong>Foto Kerusakan</strong></th>
                    <th class="text-center"><strong>Actions</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporans as $key => $laporan)
                    <tr>
                        <td>{{ $laporans->firstItem() + $key }}</td>
                        <td>{{ $laporan->kerusakan->item->nama ?? '-' }}</td>
                        <td>
                            @if ($laporan->kerusakan->item->ruang)
                                {{ $laporan->kerusakan->item->ruang->nama }}, {{ $laporan->kerusakan->item->ruang->gedung->nama }}
                            @elseif ($laporan->kerusakan->item->fasum)
                                {{ $laporan->kerusakan->item->fasum->nama }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $laporan->kerusakan->deskripsi_kerusakan }}</td>
                        <td>
                            @if($laporan->kerusakan->foto_kerusakan)
                                <img src="{{ asset('storage/' . $laporan->kerusakan->foto_kerusakan) }}" 
                                     alt="Foto Kerusakan" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" 
                                        class="btn btn-sm btn-primary detail-laporan" 
                                        data-id="{{ $laporan->laporan_id }}">
                                    Detail
                                </button>
                                <button type="button" 
                                        class="btn btn-sm btn-danger delete-kerusakan" 
                                        data-id="{{ $laporan->laporan_id }}"> 
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($laporans->hasPages())
            <x-pagination :paginator="$laporans" />
        @endif
    </div>
</div>

@include('users.kerusakan.create')
@include('users.kerusakan.show')

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
            url: "{{ url('users/kerusakan') }}/" + laporanId + "/show",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                
                // Tutup loading
                Swal.close();
                
                const laporan = response.laporan || {};
                const penugasan = response.penugasan || {};
                const kerusakan = laporan.kerusakan || {};
                const teknisi = penugasan.teknisi || {};

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

    // Delete button
    $('.delete-kerusakan').on('click', function () {
        const kerusakanId = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data kerusakan akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('kerusakan') }}/" + kerusakanId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus data kerusakan.', 'error');
                    }
                });
            }
        });
    });
});

function showCreateModal() {
    $.ajax({
        url: "{{ route('kerusakan.create') }}",
        type: 'GET',
        success: function(response) {
            window.modalData = response;
            $('#form-create')[0].reset();
            $('#step-1').show();
            $('#step-2').hide();
            $('#step-3').hide();
            $('.step-indicator').removeClass('active completed');
            $('.step-indicator[data-step="1"]').addClass('active');
            $('#btn-next').show();
            $('#btn-prev').hide();
            $('#btn-submit').hide();
            $('#createKerusakanModal').modal('show');
        },
        error: function() {
            Swal.fire('Error', 'Gagal memuat data form.', 'error');
        }
    });
}
</script>

@endsection