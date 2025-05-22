<div class="modal fade" id="editFasum" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit Data Fasum</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="form-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Error handling dari Laravel validation -->
                    @if ($errors->any() && session('editing'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Data Fasum -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_nama" class="form-label">Nama Fasilitas Umum</label>
                            <input type="text" id="edit_nama" name="nama" class="form-control" placeholder="Masukkan Nama Fasum" required>
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
    document.addEventListener('DOMContentLoaded', function() {
        $('.edit-fasum').on('click', function() {
            const fasumId = $(this).data('id');
            
            // Fetch fasum data
            $.ajax({
                url: "{{ url('admin/data/fasum') }}/" + fasumId + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const fasum = response.fasum;
                    
                    // Populate form fields
                    $('#edit_nama').val(fasum.nama);
                    
                    // Update form action
                    $('#form-edit').attr('action', "{{ url('admin/data/fasum') }}/" + fasumId);
                    
                    // Show modal
                    $('#editFasum').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal mengambil data fasum",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>