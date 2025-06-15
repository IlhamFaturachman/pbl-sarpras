@extends('layouts.app')

@section('content')
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Periode</h5>

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
                <button type="button" data-bs-toggle="modal" data-bs-target="#createPeriode" class="btn btn-outline-primary btn-sm"  style="height: 42px; align-items: center;">
                    <i class="bx bx-plus me-1"></i> Tambah
                </button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead class="table-primary">
                    <tr>
                        <th style="font-weight: bold;">No</th>
                        <th style="font-weight: bold;">Nama Periode</th>
                        <th style="font-weight: bold;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($periodes as $periode)
                        <tr>
                            <td>{{ $loop->iteration + ($periodes->firstItem() - 1) }}</td>
                            <td>{{ $periode->nama_periode }}</td>
                            <td>
                                <div class="demo-inline-spacing text-center">
                                    <div class="btn-group text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- <button type="button" class="btn btn-sm btn-primary detail-periode"
                                                data-id="{{ $periode->periode_id }}">Detail</button> -->
                                            <button type="button" class="btn btn-sm btn-warning edit-periode"
                                                data-id="{{ $periode->periode_id }}">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="showDeletePeriodeModal('{{ $periode->periode_id }}', '{{ $periode->nama_periode }}')">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada data periode</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3 me-3">
            @if ($periodes->hasPages())
                <x-pagination :paginator="$periodes" />
            @endif
        </div>

    </div>

    @include('admin.periode.show')
    @include('admin.periode.create')
    @include('admin.periode.edit')
    @include('admin.periode.delete')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: "Berhasil",
                    text: "{{ session('success') }}",
                    icon: "success",
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: "Gagal",
                    text: "{{ session('error') }}",
                    icon: "error"
                });
            @endif

            // Handle detail button click
            $('.detail-periode').on('click', function() {
                const periodeId = $(this).data('id');
                $.ajax({
                    url: "{{ url('admin/data/periode') }}/" + periodeId + "/show",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const periode = response.periode;

                        // Populate modal fields with periode data
                        $('#detail_periode_id').text(periode.periode_id);
                        $('#detail_nama_periode').text(periode.nama_periode);

                        // Show the modal
                        $('#detailPeriode').modal('show');
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Gagal mengambil detail user',
                            icon: 'error'
                        });
                    }
                });
            });

            // Handle edit button click
            $('.edit-periode').on('click', function() {
                const periodeId = $(this).data('id');

                // Fetch periode data
                $.ajax({
                    url: "{{ url('admin/data/periode') }}/" + periodeId + "/edit",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const periode = response.periode;

                        // Populate form fields
                        $('#edit_nama_periode').val(periode.nama_periode);

                        // Update form action
                        $('#form-edit').attr('action', "{{ url('admin/data/periode') }}/" +
                            periodeId);

                        // Show modal
                        $('#editPeriode').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal mengambil data periode",
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
