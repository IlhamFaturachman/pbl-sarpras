<div class="modal fade" id="tolakModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Tolak Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menolak laporan ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="tolak-form" method="GET">
          <button type="submit" class="btn btn-primary">Ya, tolak</button>
        </form>
      </div>
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
