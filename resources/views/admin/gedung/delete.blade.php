<div class="modal fade" id="deleteGedungModal" tabindex="-1" aria-hidden="true">
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
                <p>Anda yakin ingin menghapus Gedung <strong id="delete-gedung-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <form id="delete-form-gedung" action="" method="POST">
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
        window.showDeleteGedungModal = function (gedungId, gedungName) {
            const modalElement = document.getElementById('deleteGedungModal');

            if (!modalElement) {
                console.error('Modal element not found!');
                return;
            }

            // Set nama dan form action
            document.getElementById('delete-gedung-name').textContent = gedungName;
            document.getElementById('delete-form-gedung').action = "{{ url('admin/data/gedung') }}/" + gedungId;

            // Tampilkan modal
            const deleteModal = new bootstrap.Modal(modalElement);
            deleteModal.show();
        };

        // Reset form jika modal ditutup (opsional)
        $('#deleteGedungModal').on('hidden.bs.modal', function () {
            $('#delete-form-gedung')[0].reset();
        });
    });
</script>
