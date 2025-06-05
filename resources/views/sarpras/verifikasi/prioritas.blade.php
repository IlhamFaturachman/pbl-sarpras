<div class="modal fade" id="prioritasModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content text-dark" style="background-color:rgba(235, 235, 235, 0.96);">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm mb-3">
          <div class="card-header border-bottom">
            <h5 class="mb-0">Verifikasi Kerusakan Fasilitas</h5>
          </div>
          <div class="card-body">
            <div class="row">

              <div class="col-md-12 mb-3 mt-7">
                <label for="tingkat_kerusakan">Tingkat Kerusakan: <span id="val_kerusakan">0</span>%</label>
                <input type="range" id="tingkat_kerusakan" class="form-range" min="0" max="100" value="0">
              </div>

              <div class="col-md-12 mb-3">
                <label for="tingkat_dampak">Tingkat Dampak: <span id="val_dampak">0</span>%</label>
                <input type="range" id="tingkat_dampak" class="form-range" min="0" max="100" value="0">
              </div>

              <div class="col-md-12 mb-3">
                <label for="jumlah_terdampak">Jumlah Civitas Terdampak: <span id="val_terdampak">0</span> Orang</label>
                <input type="range" id="jumlah_terdampak" class="form-range" min="0" max="100" value="0">
              </div>

              <div class="col-md-12 mb-3">
                <label for="alternatif">Ketersediaan Alternatif: <span id="val_alternatif"></span></label>                
                <div>
                   <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="alternatif" id="alternatif_ada" value="0" checked>
                      <label class="form-check-label" for="alternatif_ada">Ada</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="alternatif" id="alternatif_tidak_ada" value="1">
                      <label class="form-check-label" for="alternatif_tidak_ada">Tidak Ada</label>
                    </div>
                </div>                
              </div>
              
              <div class="col-md-12 mb-3">
                <label for="keamanan">Tingkat Keamanan Terancam: <span id="val_keamanan">0</span>%</label>
                <input type="range" id="keamanan" class="form-range" min="0" max="100" value="0">
              </div>

            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" id="btnSimpanPrioritas" class="btn btn-primary" data-bs-dismiss="modal">Verifikasi</button>
        </div>
      </div>
    </div>
  </div>
</div>
