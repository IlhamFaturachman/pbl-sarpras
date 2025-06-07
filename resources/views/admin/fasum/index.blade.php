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
        <h5 class="mb-0">Data Fasilitas Umum</h5>
        <button type="button" data-bs-toggle="modal" data-bs-target="#createFasum" class="btn btn-outline-primary">
            <i class="bx bx-plus me-1"></i> Tambah
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th class="align-middle" style="font-weight: bold;">No</th>
                    <th class="align-middle" style="font-weight: bold;">Nama Fasilitas Umum</th>
                    <th class="align-middle text-center" style="font-weight: bold;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($fasums as $fasum)
                    <tr>
                        <td>{{ $loop->iteration + ($fasums->firstItem() - 1) }}</td>
                        <td class="align-middle">{{ $fasum->nama }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-warning edit-fasum" data-id="{{ $fasum->fasum_id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal('{{ $fasum->fasum_id }}', '{{ $fasum->nama }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada data fasilitas umum</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($fasums->hasPages())
            <x-pagination :paginator="$fasums" />
        @endif
    </div>
    
</div>

@include('admin.fasum.create')
@include('admin.fasum.edit')
@include('admin.fasum.delete')

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
});
</script>
@endsection