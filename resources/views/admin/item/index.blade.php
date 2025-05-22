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
        <h5 class="mb-0">Data Item</h5>
        <button type="button" data-bs-toggle="modal" data-bs-target="#createItem" class="btn btn-outline-primary">
            <i class="bx bx-plus me-1"></i> Tambah
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">Nama Item</th>
                    <th class="text-center" style="font-weight: bold;">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-warning edit-item" data-id="{{ $item->item_id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal('{{ $item->item_id }}', '{{ $item->nama }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($items->hasPages())
            <x-pagination :paginator="$items" />
        @endif
    </div>
    
</div>
@include('admin.item.create')
@include('admin.item.edit')
@include('admin.item.delete')  

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