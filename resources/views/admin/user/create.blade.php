<form action="{{ route('user.store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="createUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Data User</h5>
                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error handling dari Laravel validation -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="row">
                        <!-- Foto Profil -->
                        <div class="col-md-12 text-center mb-4">
                            <label for="foto_profile" style="cursor: pointer;">
                                <img id="preview-image" src="{{ asset('assets/img/avatars/default-avatar.png') }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </label>
                            <input type="file" class="d-none" id="foto_profile" name="foto_profile" accept="image/*">
                            <small class="text-muted d-block">Klik untuk upload</small>
                        </div>
                    </div>

                    <!-- Data User -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required value="{{ old('nama_lengkap') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nomor_induk" class="form-label">Nomor Induk</label>
                            <input type="text" id="nomor_induk" name="nomor_induk" class="form-control" placeholder="Masukkan Nomor Induk" required value="{{ old('nomor_induk') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Username</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Pengguna" required value="{{ old('nama') }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="contoh@email.com" required value="{{ old('email') }}">
                        </div>
                        <div class="col mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="status" name="status" value="Tidak Aktif">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Preview image sebelum upload
    $('#foto_profile').on('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => $('#preview-image').attr('src', e.target.result);
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Reset form saat modal dibuka
    $('#createUser').on('show.bs.modal', function () {
        $('#form-tambah')[0].reset();
        $('.text-danger').html('');
        $('#preview-image').attr('src', '{{ asset("assets/img/avatars/default-avatar.png") }}');
    });

    // Auto-open modal jika ada error dari server (misal pada reload pertama)
    @if($errors->any())
        $(document).ready(function () {
            $('#createUser').modal('show');
        });
    @endif
</script>