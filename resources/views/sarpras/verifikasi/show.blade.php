<div class="modal fade" id="detailLaporan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content text-white" style="background-color:rgba(235, 235, 235, 0.96);">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">

        <!-- Detail Laporan Kerusakan -->
        <div class="card shadow-sm mb-4">
          <div class="card-header border-bottom d-flex align-items-center gap-2">
            <h5 class="mb-0">Detail Laporan Kerusakan</h5>
            <span id="status_laporan"></span>
        </div>
          <div class="card-body pt-5">
            <div class="row">
              <!-- Kiri -->
              <div class="col-md-8">
                <div class="mb-3">
                  <div class="fw-semibold">ID Laporan</div>
                  <div class="mt-1" id="detail_laporan_id"></div>
                </div>
                <div class="mb-3">
                  <div class="fw-semibold">Tanggal Laporan</div>
                  <div class="mt-1" id="detail_tanggal_laporan"></div>
                </div>
                <div class="mb-3">
                  <div class="fw-semibold">Nama Sarana</div>
                  <div class="mt-1" id="detail_item"></div>
                </div>
                <div class="mb-3">
                  <div class="fw-semibold">Lokasi Fasilitas</div>
                  <div class="mt-1" id="detail_lokasi_fasilitas"></div>
                </div>
                <div class="mb-3">
                  <div class="fw-semibold">Deskripsi Kerusakan</div>
                  <div class="mt-1" id="detail_deskripsi_kerusakan"></div>
                </div>
                <div class="mb-3">
                  <div class="fw-semibold">Nama Pelapor</div>
                  <div class="mt-1" id="detail_pelapor"></div>
                </div>
              </div>

              <!-- Kanan -->
              <div class="col-md-4">
                <div class="fw-semibold mb-2">Bukti Kerusakan</div>
                <img id="detail_foto_kerusakan" class="img-fluid rounded shadow-sm" width="240px" />
              </div>
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
</div>
