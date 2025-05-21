@extends('layouts.app')

@section('content')

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

<div class="row">
    <!-- Kolom Kanan: Edit Foto Profil -->
    <div class="col-md-4 d-flex align-items-center">
        <div class="card w-100 p-3">
            <div class="card-header text-center border-0 pb-0">
                <h5 class="mb-3">Edit Foto Profil</h5>
            </div>
            <div class="card-body d-flex flex-column align-items-center">
                <img src="{{ asset(Auth::user()->foto_profile ? 'storage/' . Auth::user()->foto_profile : 'assets/img/avatars/default-avatar.png') }}" 
                    class="rounded-circle mb-3 shadow-sm" 
                    width="150" height="150" 
                    alt="Foto Profil">
                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="w-100">
                    @csrf
                    <div class="form-group text-center mb-3">
                        <label for="foto_profile" class="form-label">Foto Profil</label>
                        <input type="file" name="foto_profile" id="foto_profile" class="form-control mt-1">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Update Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Kiri: Form -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Profil Saya</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label" for="nomor_induk">Nomor Induk</label>
                        <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ old('nomor_induk', Auth::user()->nomor_induk) }}" />
                        @error('nomor_induk')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}" />
                        @error('nama_lengkap')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">Username</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', Auth::user()->nama) }}" />
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"/>
                        <label class="text-muted" for="password">Kosongkan jika tidak ingin mengganti password</label>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="status">Status Akun :</label>
                        <span class="badge {{ Auth::user()->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                            {{ Auth::user()->status }}
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection