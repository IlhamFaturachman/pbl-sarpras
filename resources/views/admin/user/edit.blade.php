<form action="{{ route('user.update', $user->user_id) }}" method="POST" id="form-edit" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Data User</h5>
                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error handling dari Laravel validation -->
                    @if ($errors->any() && session('editing'))
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
                            <label for="edit_foto_profile" style="cursor: pointer;">
                                <img id="edit-preview-image" src="{{ $editUser->foto_profile ? asset('storage/'.$editUser->foto_profile) : asset('assets/img/avatars/default-avatar.png') }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </label>
                            <input type="file" class="d-none" id="edit_foto_profile" name="foto_profile" accept="image/*">
                            <small class="text-muted d-block">Klik untuk upload</small>
                        </div>
                    </div>

                    <!-- Data User -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="edit_nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required value="{{ old('nama_lengkap', $editUser->nama_lengkap) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_nomor_induk" class="form-label">Nomor Induk</label>
                            <input type="text" id="edit_nomor_induk" name="nomor_induk" class="form-control" placeholder="Masukkan Nomor Induk" required value="{{ old('nomor_induk', $editUser->nomor_induk) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_nama" class="form-label">Username</label>
                            <input type="text" id="edit_nama" name="nama" class="form-control" placeholder="Masukkan Nama Pengguna" required value="{{ old('nama', $editUser->nama) }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control" placeholder="contoh@email.com" required value="{{ old('email', $editUser->email) }}">
                        </div>
                        <div class="col mb-3">
                            <label for="edit_password" class="form-label">Password</label>
                            <input type="password" id="edit_password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengganti">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select id="edit_role" name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ (old('role', $userRole) == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select id="edit_status" name="status" class="form-select" required>
                                <option value="Aktif" {{ (old('status', $editUser->status) == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ (old('status', $editUser->status) == 'Tidak Aktif') ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
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
    // Preview image before upload
    $('#edit_foto_profile').on('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => $('#edit-preview-image').attr('src', e.target.result);
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Auto-open modal if there are validation errors for edit form
    @if($errors->any() && session('editing'))
        $(document).ready(function() {
            $('#editUser').modal('show');
        });
    @endif
</script>