<div class="modal fade" id="detailUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <!-- Foto Profil -->
                <div class="row mb-4">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="text-center">
                            <img id="detail_foto_profile"
                                 src="{{ asset('assets/img/avatars/default-avatar.png') }}"
                                 class="img-thumbnail rounded-circle"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <!-- Informasi Pengguna -->
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h6 class="mb-0">Informasi Pengguna</h6>
                    </div>
                    <div class="card-body pt-4">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="fw-semibold">Nomor Induk</div>
                                    <div class="mt-1" id="detail_nomor_induk"></div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-semibold">Nama Lengkap</div>
                                    <div class="mt-1" id="detail_nama_lengkap"></div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-semibold">Jenis Pengguna</div>
                                    <div class="mt-1" id="detail_role"></div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="fw-semibold">Username</div>
                                    <div class="mt-1" id="detail_nama"></div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-semibold">Email</div>
                                    <div class="mt-1" id="detail_email"></div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-semibold">Status</div>
                                    <div class="mt-1" id="detail_status"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto Identitas -->
                <div class="card">
                    <div class="card-header border-bottom">
                        <h6 class="mb-0">Foto Identitas Civitas Akademik</h6>
                    </div>
                    <div class="card-body text-center pt-4">
                        <img id="detail_foto_identitas"
                             src="{{ asset('assets/img/default-ktm.png') }}"
                             class="img-thumbnail"
                             style="width: 270px; height: 170px; object-fit: cover;">
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
