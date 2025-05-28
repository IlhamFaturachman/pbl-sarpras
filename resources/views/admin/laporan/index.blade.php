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
        <button type="button" data-bs-toggle="modal" data-bs-target="#createItem" class="btn btn-outline-primary">
            <i class="bx bx-plus me-1"></i> Tambah
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">ID Laporan</th>
                    <th style="font-weight: bold;">Nama Pelapor</th>
                    <th style="font-weight: bold;">Nama Verifikator</th>
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
                        <td>{{ $laporan->pelapor->nama_lengkap }}</td>
                        <td>{{ $laporan->verifikator->nama_lengkap }}</td>
                        @if ($laporan->kerusakan->fasum_id == null)
                            <td>{{ Str::limit($laporan->kerusakan->ruang->gedung->nama, 30, '...') }}</td>
                        @else 
                            <td>{{ $laporan->kerusakan->fasum->nama }}</td>
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
                                <button type="button" class="btn btn-sm btn-primary detail-laporan" data-bs-toggle="modal" data-bs-target="#detailLaporanAdmin" data-id="{{ $laporan->laporan_id }}">Detail</button>
                                <button type="button" class="btn btn-sm btn-warning edit-laporan" data-id="{{ $laporan->laporan_id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal('{{ $laporan->laporan_id }}', '{{ $laporan->nama }}')">Hapus</button>
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
{{-- @include('admin.item.create')
@include('admin.item.edit')
@include('admin.item.delete')   --}}

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