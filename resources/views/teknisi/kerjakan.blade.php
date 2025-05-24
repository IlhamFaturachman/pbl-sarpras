<div class="modal fade" id="kerjakanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Mulai Mengerjakan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin mulai mengerjakan penugasan ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="kerjakan-form" method="GET">
          <button type="submit" class="btn btn-primary">Ya, kerjakan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function showKerjakanModal(id) {
    const form = document.getElementById('kerjakan-form');
    form.action = "{{ url('teknisi/penugasan') }}/" + id;

    const kerjakanModal = new bootstrap.Modal(document.getElementById('kerjakanModal'));
    kerjakanModal.show();
  }

  // Optional: reset form on close
  $('#kerjakanModal').on('hidden.bs.modal', function () {
    $('#kerjakan-form').attr('action', '');
  });
</script>
