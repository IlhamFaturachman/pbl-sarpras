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
                @foreach($kerusakans as $key => $kerusakan)
                    <tr>
                        <td>{{ $kerusakans->firstItem() + $key }}</td>
                        <td>{{ $kerusakan->item->nama ?? '-' }}</td>
                        <td>
                            @if ($kerusakan->ruang)
                                {{ $kerusakan->ruang->nama }}, {{ $kerusakan->ruang->gedung->nama }}
                            @elseif ($kerusakan->fasum)
                                {{ $kerusakan->fasum->nama }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $kerusakan->deskripsi_kerusakan }}</td>
                        <td>
                            @if($kerusakan->foto_kerusakan)
                                <img src="{{ asset('storage/' . $kerusakan->foto_kerusakan) }}" 
                                     alt="Foto Kerusakan" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-danger delete-kerusakan" 
                                        data-id="{{ $kerusakan->kerusakan_id }}">
                                    <i class="fas fa-trash"></i>
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
        @if ($kerusakans->hasPages())
            <x-pagination :paginator="$kerusakans" />
        @endif
    </div>
</div>

@include('users.kerusakan.create')

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