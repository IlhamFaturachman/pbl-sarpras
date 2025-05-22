<div class="modal fade" id="editGedung" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGedungModalLabel">Edit Data Gedung</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="form-edit-gedung" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Error handling dari Laravel validation -->
                    @if ($errors->any() && session('editing_gedung'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Data Gedung -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_nama_gedung" class="form-label">Nama Gedung</label>
                            <input type="text" id="edit_nama_gedung" name="nama" class="form-control" placeholder="Masukkan Nama Gedung" required>
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
        $('.edit-gedung').on('click', function () {
            const gedungId = $(this).data('id');

            // Fetch gedung data
            $.ajax({
                url: "{{ url('admin/data/gedung') }}/" + gedungId + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const gedung = response.gedung;

                    // Populate form fields
                    $('#edit_nama_gedung').val(gedung.nama);

                    // Update form action
                    $('#form-edit-gedung').attr('action', "{{ url('admin/data/gedung') }}/" + gedungId);

                    // Show modal
                    $('#editGedung').modal('show');
                },
                error: function (xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal mengambil data gedung",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>
