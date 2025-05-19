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
        <h5 class="mb-0">Data User</h5>
        <button type="button" data-bs-toggle="modal" data-bs-target="#createUser" class="btn btn-outline-primary">
            <i class="bx bx-plus me-1"></i> Tambah
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="font-weight: bold;">Nama</th>
                    <th style="font-weight: bold;">Nomor Induk</th>
                    <th style="font-weight: bold;">Username</th>
                    <th style="font-weight: bold;">Email</th>
                    <th style="font-weight: bold;">Status</th>
                    <th style="font-weight: bold;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->nomor_induk }}</td>
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
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3 me-3">
        @if ($users->hasPages())
            <x-pagination :paginator="$users" />
        @endif
    </div>
    
</div>

@include('admin.user.create')
@include('admin.user.edit')
@include('admin.user.delete')
@include('admin.user.show')

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
    });
</script>
@endsection