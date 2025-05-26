<div class="modal fade" id="detailLaporanAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Data Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-4">ID Laporan</div>
                    <strong class="col-md-8" id="detail_nama_lengkap"></strong>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Nama Pelapor</div>
                    <strong class="col-md-8" id="detail_nomor_induk"></strong>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">Fasilitas</div>
                    <strong class="col-md-8" id="detail_nama"></strong>
                </div>
                @if ($laporans->kerusakan->fasum_id == null)
                    <div class="row mb-2">
                        <div class="col-md-4">Ruang</div>
                        <strong class="col-md-8" id="detail_nama"></strong>
                    </div>
                @endif
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