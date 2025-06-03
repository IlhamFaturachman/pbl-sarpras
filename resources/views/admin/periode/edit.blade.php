<div class="modal fade" id="editPeriode" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPeriodeModalLabel">Edit Data Periode</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="form-edit-periode" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Error handling dari Laravel validation -->
                    @if ($errors->any() && session('editing_periode'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Data Periode -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_nama_periode" class="form-label">Nama Periode</label>
                            <input type="text" id="edit_nama_periode" name="nama_periode" class="form-control" placeholder="Masukkan Nama Periode" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.edit-periode').on('click', function () {
            const periodeId = $(this).data('id');

            // Fetch periode data
            $.ajax({
                url: "{{ url('admin/data/periode') }}/" + periodeId + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const periode = response.periode;

                    // Populate form fields
                    $('#edit_kode_periode').val(periode.kode);
                    $('#edit_nama_periode').val(periode.nama);

                    // Update form action
                    $('#form-edit-periode').attr('action', "{{ url('admin/data/periode') }}/" + periodeId);

                    // Show modal
                    $('#editPeriode').modal('show');
                },
                error: function (xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal mengambil data periode",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>

