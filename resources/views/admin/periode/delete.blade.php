<div class="modal fade" id="deletePeriodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus Periode <strong id="delete-periode-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <form id="delete-form-periode" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.showDeletePeriodeModal = function (periodeId, periodeName) {
            const modalElement = document.getElementById('deletePeriodeModal');

            if (!modalElement) {
                console.error('Modal element not found!');
                return;
            }

            // Set nama dan form action
            document.getElementById('delete-periode-name').textContent = periodeName;
            document.getElementById('delete-form-periode').action = "{{ url('admin/data/periode') }}/" + periodeId;

            // Tampilkan modal
            const deleteModal = new bootstrap.Modal(modalElement);
            deleteModal.show();
        };

        // Reset form jika modal ditutup (opsional)
        $('#deletePeriodeModal').on('hidden.bs.modal', function () {
            $('#delete-form-periode')[0].reset();
        });
    });
</script>

