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
        <h5 class="mb-0">Data Gedung</h5>
        <button type="button" data-bs-toggle="modal" data-bs-target="#createGedung" class="btn btn-outline-primary">
            <i class="bx bx-plus me-1"></i> Tambah
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">Kode Gedung</th>
                    <th style="font-weight: bold;">Nama Gedung</th>
                    <th style="font-weight: bold;" class="text-center">Actions</>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($gedungs as $gedung)
                    <tr>
                        <td>{{ $gedung->kode }}</td>
                        <td>{{ $gedung->nama }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-warning edit-gedung" data-id="{{ $gedung->gedung_id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal('{{ $gedung->gedung_id }}', '{{ $gedung->nama }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($gedungs->hasPages())
            <x-pagination :paginator="$gedungs" />
        @endif
    </div>
</div>

@include('admin.gedung.create')
@include('admin.gedung.edit')
@include('admin.gedung.delete')

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
