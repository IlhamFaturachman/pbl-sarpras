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
        <h5 class="mb-0">Data Sarana</h5>

        <div class="d-flex align-items-center gap-2" style="max-width: 100%;">
            <div class="position-relative" style="max-width: 300px; width: 100%;">
                <i class="bi bi-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                <input 
                    type="text" 
                    id="searchInput" 
                    class="form-control form-control-sm" 
                    placeholder="Cari..." 
                    style="background-color: #f8f9fa; border: 1px solid #ced4da; color: #495057; font-weight: 400; font-size: 1rem; height: 42px; padding-left: 2.5rem;" />
            </div>
            <button type="button" data-bs-toggle="modal" data-bs-target="#createItem" class="btn btn-outline-primary btn-sm"  style="height: 42px; align-items: center;">
                <i class="bx bx-plus me-1"></i> Tambah
            </button>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Nama Sarana</th>
                    <th style="font-weight: bold;">Lokasi</th>
                    <th class="text-center" style="font-weight: bold;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($items->firstItem() - 1) }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->ruang ? $item->ruang->gedung->nama . ', ' . $item->ruang->nama : $item->fasum->nama }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-warning" onclick="editItem({{ $item->item_id }})" data-id="{{ $item->item_id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal('{{ $item->item_id }}', '{{ $item->nama }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada data sarana</td>
                </tr>
                @endforelse
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