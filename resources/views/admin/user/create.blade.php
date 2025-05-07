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
                    <div class="alert alert-danger d-none" id="general-error-alert">
                        <ul id="general-error-list"></ul>
                    </div>
                    
                    <div class="row">
                        <!-- Foto Profil -->
                        <div class="col-md-12 text-center mb-4">
                            <label for="foto_profile" style="cursor: pointer;">
                                <img id="preview-image" src="{{ asset('assets/img/avatars/default-avatar.png') }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </label>
                            <input type="file" class="d-none" id="foto_profile" name="foto_profile" accept="image/*">
                            <small id="error-foto_profile" class="text-danger form-text"></small>
                            <small class="text-muted d-block">Klik untuk upload</small>
                        </div>
                    </div>

                    <!-- Data User -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                            <small id="error-nama_lengkap" class="text-danger form-text"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nomor_induk" class="form-label">Nomor Induk</label>
                            <input type="text" id="nomor_induk" name="nomor_induk" class="form-control" placeholder="Masukkan Nomor Induk" required>
                            <small id="error-nomor_induk" class="text-danger form-text"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Username</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Pengguna" required>
                            <small id="error-nama" class="text-danger form-text"></small>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                            <small id="error-email" class="text-danger form-text"></small>
                        </div>
                        <div class="col mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                            <small id="error-password" class="text-danger form-text"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <small id="error-role" class="text-danger form-text"></small>
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
    $('#foto_profile').on('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => $('#preview-image').attr('src', e.target.result);
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#createUser').on('show.bs.modal', function() {
        $('#form-tambah')[0].reset();
        $('#preview-image').attr('src', '{{ asset("assets/img/avatars/default-avatar.png") }}');
        $('.text-danger.form-text').text('');
        $('#general-error-alert').addClass('d-none');
        $('#general-error-list').html('');
    });

    $("#form-tambah").on('submit', function(e) {
        e.preventDefault();
        
        // Reset error messages
        $('.text-danger.form-text').text('');
        $('#general-error-alert').addClass('d-none');
        $('#general-error-list').html('');
        
        let formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    $('#createUser').modal('hide');
                    Swal.fire({
                        title: "Berhasil",
                        text: res.messages,
                        icon: "success"
                    });
                    if (typeof dataUser !== 'undefined') {
                        dataUser.ajax.reload();
                    }
                } else {
                    if (res.msgField) {
                        $.each(res.msgField, function(key, value) {
                            $('#error-' + key).text(value[0]);
                        });
                    }
                    
                    Swal.fire({
                        title: "Gagal",
                        text: res.messages,
                        icon: "error"
                    });
                    
                    // Display error in alert box
                    if (res.error) {
                        $('#general-error-alert').removeClass('d-none');
                        $('#general-error-list').append('<li>' + res.error + '</li>');
                    }
                }
            },
            error: function(xhr, status, error) {
                $('#general-error-alert').removeClass('d-none');
                
                // Try to parse error response
                try {
                    var errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse.message) {
                        $('#general-error-list').append('<li>' + errorResponse.message + '</li>');
                    } else {
                        $('#general-error-list').append('<li>Terjadi kesalahan pada server</li>');
                    }
                } catch (e) {
                    $('#general-error-list').append('<li>Terjadi kesalahan pada server</li>');
                }
                
                Swal.fire({
                    title: "Error",
                    text: "Terjadi kesalahan saat mengirim data",
                    icon: "error"
                });
            }
        });
        
        return false;
    });
</script>