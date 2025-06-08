<div class="modal fade" id="tolakModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Tolak Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <form id="tolak-form" method="GET">
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menolak laporan ini?</p>
          <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
          <input type="text" id="alasan_penolakan" name="alasan_penolakan" class="form-control"
          placeholder="Masukkan alasan penolakan jika memilih 'Tolak'" value="{{ old('alasan_penolakan') }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Tolak</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
  function showTolakModal(id) {
    const form = document.getElementById('tolak-form');
    form.action = "{{ url('sarpras/laporan/verifikasi') }}/" + id;

    const tolakModal = new bootstrap.Modal(document.getElementById('tolakModal'));
    tolakModal.show();
  }

  // Optional: reset form on close
  $('#tolakModal').on('hidden.bs.modal', function () {
    $('#tolak-form').attr('action', '');
  });
</script>
