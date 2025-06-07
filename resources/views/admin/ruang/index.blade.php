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
        <h5 class="mb-0">Data Ruang</h5>
        <button type="button" data-bs-toggle="modal" data-bs-target="#createRuang" class="btn btn-outline-primary">
            <i class="bx bx-plus me-1"></i> Tambah
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Kode Ruang</th>
                    <th style="font-weight: bold;">Nama Ruang</th>
                    <th style="font-weight: bold;">Kode Gedung</th>
                    <th style="font-weight: bold;">Nama Gedung</th>
                    <th style="font-weight: bold;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($ruangs as $ruang)
                    <tr>
                        <td>{{ $loop->iteration + ($ruangs->firstItem() - 1) }}</td>
                        <td>{{ $ruang->kode }}</td>
                        <td>{{ $ruang->nama }}</td>
                        <td>{{ $ruang->gedung->kode }}</td>
                        <td>{{ $ruang->gedung->nama }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary detail-ruang" data-id="{{ $ruang->ruang_id }}">Detail</button>
                                <button type="button" class="btn btn-sm btn-warning edit-ruang" data-id="{{ $ruang->ruang_id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal('{{ $ruang->ruang_id }}', '{{ $ruang->nama }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data ruang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($ruangs->hasPages())
            <x-pagination :paginator="$ruangs" />
        @endif
    </div>
    
</div>

@include('admin.ruang.create')
@include('admin.ruang.edit')
@include('admin.ruang.delete')
@include('admin.ruang.show')

<!-- SweetAlert Script -->
<script>
    // Auto-trigger SweetAlert for success or error messages
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

        @if(session('adding'))
            // Buka modal tambah user otomatis setelah validasi gagal
            var createRuangModal = new bootstrap.Modal(document.getElementById('createRuang'));
            createRuangModal.show();
        @endif

        
        // Handle detail button click
        $('.detail-ruang').on('click', function () {
            const ruangId = $(this).data('id');
            $.ajax({
                url: "{{ url('admin/data/ruang') }}/" + ruangId + "/show",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const ruang = response.ruang;
                    const gedung = response.gedung;
                    
                    // Populate modal fields with ruang data
                    $('#detail_ruang_id').text(ruang.ruang_id);
                    $('#detail_kode').text(ruang.kode);
                    $('#detail_nama').text(ruang.nama);
                    $('#detail_gedungKode').text(gedung.kode);
                    $('#detail_gedungNama').text(gedung.nama);
                    $('#detail_lantai').text(ruang.lantai);

                    // Show the modal
                    $('#detailRuang').modal('show');
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
        $('.edit-ruang').on('click', function() {
            const ruangId = $(this).data('id');
            
            // Fetch ruang data
            $.ajax({
                url: "{{ url('admin/data/ruang') }}/" + ruangId + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const ruang = response.ruang;
                    const gedung = response.gedung;
                    
                    // Populate form fields
                    $('#edit_kode').val(ruang.kode);
                    $('#edit_nama').val(ruang.nama);
                    $('#edit_lantai').val(ruang.lantai);
                    $('#edit_gedung').val(ruang.gedung_id);

                    // Update form action
                    $('#form-edit').attr('action', "{{ url('admin/data/ruang') }}/" + ruangId);
                    
                    // Show modal
                    $('#editRuang').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal mengambil data ruang",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>

@endsection
