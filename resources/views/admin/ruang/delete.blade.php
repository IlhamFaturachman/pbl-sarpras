<form method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus ruang <strong id="delete-nama"></strong>?</p>
                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Fungsi untuk menampilkan modal hapus
    function showDeleteModal(ruangId, nama) {
        $('#delete-nama').text(nama);
        $('#form-delete').attr('action', `/admin/data/ruang/${ruangId}`);
        $('#deleteModal').modal('show');
    }

    // Tangani submit form delete
    $('#form-delete').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const actionUrl = form.attr('action');
        const formData = form.serialize();

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#deleteModal').modal('hide');
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Data berhasil dihapus',
                    icon: 'success',
                    timer: 2000
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menghapus data',
                    icon: 'error'
                });
            }
        });
    });

    // Reset form saat modal ditutup
    $('#deleteModal').on('hidden.bs.modal', function () {
        $('#form-delete')[0].reset();
        $('#form-delete').attr('action', '');
        $('#delete-nama').text('');
    });
</script>
