<div class="modal fade" id="detailUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Detail Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="row">
                    <!-- Foto Profil -->
                    <div class="col-md-12 text-center mb-4">
                        <img id="detail_foto_profile"
                             src="{{ asset('assets/img/avatars/default-avatar.png') }}"
                             class="img-thumbnail rounded-circle"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </div>

                <!-- Informasi User -->
                <div class="row mb-2">
                    <div class="col-md-4">Nama Lengkap</div>
                    <strong class="col-md-8" id="detail_nama_lengkap"></strong>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Nomor Induk</div>
                    <strong class="col-md-8" id="detail_nomor_induk"></strong>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Username</div>
                    <strong class="col-md-8" id="detail_nama"></strong>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Email</div>
                    <strong class="col-md-8" id="detail_email"></strong>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Role</div>
                    <strong class="col-md-8" id="detail_role"></strong>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Status</div>
                    <strong class="col-md-8" id="detail_status"></strong>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>