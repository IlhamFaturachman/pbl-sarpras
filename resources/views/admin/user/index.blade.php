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
        <h5 class="mb-0">Data Pengguna</h5>
        
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#createUser" class="btn btn-outline-primary btn-sm"  style="height: 42px; align-items: center;">
                <i class="bx bx-plus me-1"></i> Tambah
            </button>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Nomor Induk</th>
                    <th style="font-weight: bold;">Nama Lengkap</th>
                    <th style="font-weight: bold;">Jenis Pengguna
                        <div class="dropdown d-inline-block">
                            <a class="text-decoration-none text-dark dropdown-toggle" href="#" role="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-filter" style="font-size: 1.1rem;"></i>
                            </a>
                                <ul class="dropdown-menu" aria-labelledby="filterDropdown" style="font-size: 0.85rem; padding: 0.25rem 0;">
                                <li><a class="dropdown-item filter-role" data-value="">Semua</a></li>
                                <li><a class="dropdown-item filter-role" data-value="Admin">Admin</a></li>
                                <li><a class="dropdown-item filter-role" data-value="Dosen">Dosen</a></li>
                                <li><a class="dropdown-item filter-role" data-value="Tendik">Tendik</a></li>
                                <li><a class="dropdown-item filter-role" data-value="Mahasiswa">Mahasiswa</a></li>
                                <li><a class="dropdown-item filter-role" data-value="Teknisi">Teknisi</a></li>
                                <li><a class="dropdown-item filter-role" data-value="Sarpras">Sarpras</a></li>
                            </ul>
                        </div>
                    </th>
                    <th style="font-weight: bold;">Username</th>
                    <th style="font-weight: bold;">Email</th>
                    <th style="font-weight: bold;">Status</th>
                    <th style="font-weight: bold;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->firstItem() - 1) }}</td>
                        <td>{{ $user->nomor_induk }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ \Illuminate\Support\Str::title($user->getRoleNames()->first()) }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-label-{{ $user->status == 'Aktif' ? 'success' : 'danger' }} me-1">{{ $user->status }}</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary detail-user" data-id="{{ $user->user_id }}">Detail</button>
                                <button type="button" class="btn btn-sm btn-warning edit-user" data-id="{{ $user->user_id }}">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteModal('{{ $user->user_id }}', '{{ $user->nama_lengkap }}')">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data pengguna</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @php
        $paginator = $users->appends(request()->query());
    @endphp

    <div class="d-flex justify-content-end mt-3 me-3">
        <x-pagination :paginator="$paginator" />
    </div>
    
</div>

@include('admin.user.create')
@include('admin.user.edit')
@include('admin.user.delete')
@include('admin.user.show')

<style>
    /* Sembunyikan icon panah dropdown bawaan Bootstrap */
    .dropdown-toggle::after {
    display: none !important;
    }

</style>

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
            var createUserModal = new bootstrap.Modal(document.getElementById('createUser'));
            createUserModal.show();
        @endif
        
        function toTitleCase(str) {
            return str.toLowerCase().split(' ').map(function(word) {
                return word.charAt(0).toUpperCase() + word.slice(1);
            }).join(' ');
        }
        
        // Handle detail button click
        $('.detail-user').on('click', function () {
            const userId = $(this).data('id');
            $.ajax({
                url: "{{ url('admin/data/user') }}/" + userId + "/show",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const user = response.user;
                    const userRole = response.userRole;
                    
                    // Populate modal fields with user data
                    $('#detail_nama_lengkap').text(user.nama_lengkap);
                    $('#detail_user_id').text(user.user_id);
                    $('#detail_nomor_induk').text(user.nomor_induk);
                    $('#detail_nama').text(user.nama);
                    $('#detail_email').text(user.email);
                    $('#detail_role').text(toTitleCase(userRole));
                    $('#detail_status').text(user.status);

                    if (user.foto_profile) {
                        $('#detail_foto_profile').attr('src', "{{ asset('storage') }}/" + user.foto_profile);
                    } else {
                        $('#detail_foto_profile').attr('src', "{{ asset('assets/img/avatars/default-avatar.png') }}");
                    }

                    if (user.identitas) {
                        $('#detail_foto_identitas').attr('src', "{{ asset('storage') }}/" + user.identitas);
                    } else {
                        $('#detail_foto_identitas').attr('src', "{{ asset('assets/img/avatars/default-avatar.png') }}");
                    }

                    // Show the modal
                    $('#detailUser').modal('show');
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
        $('.edit-user').on('click', function() {
            const userId = $(this).data('id');
            
            // Fetch user data
            $.ajax({
                url: "{{ url('admin/data/user') }}/" + userId + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const user = response.user;
                    const userRole = response.userRole;
                    
                    // Populate form fields
                    $('#edit_nama_lengkap').val(user.nama_lengkap);
                    $('#edit_nomor_induk').val(user.nomor_induk);
                    $('#edit_nama').val(user.nama);
                    $('#edit_email').val(user.email);
                    $('#edit_password').val(''); // Clear password field
                    $('#edit_role').val(userRole);
                    $('#edit_status').val(user.status);
                    
                    // Update form action
                    $('#form-edit').attr('action', "{{ url('admin/data/user') }}/" + userId);
                    
                    // Update profile image
                    if (user.foto_profile) {
                        $('#edit-preview-image').attr('src', "{{ asset('storage') }}/" + user.foto_profile);
                    } else {
                        $('#edit-preview-image').attr('src', "{{ asset('assets/img/avatars/default-avatar.png') }}");
                    }
                    
                    // Show modal
                    $('#editUser').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal mengambil data user",
                        icon: "error"
                    });
                }
            });
        });

        $('.filter-role').on('click', function () {
            const selectedRole = $(this).data('value').toLowerCase();

            $('table tbody tr').each(function () {
                const roleCell = $(this).find('td').eq(4); // kolom role
                const roleText = roleCell.text().toLowerCase().trim();

                if (!selectedRole || roleText.includes(selectedRole)) {
                    $(this).show();
                } else {
                    $(this).hide();
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