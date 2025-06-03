<form action="{{ route('periode.store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="createPeriode" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Data Periode</h5>
                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Error handling dari Laravel validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Input Nama Periode --}}
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Nama Periode</label>
                            <input type="text" id="nama" name="nama_periode" class="form-control" placeholder="Masukkan Nama Periode" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Sertakan jQuery SEBELUM script yang pakai $ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Reset form saat modal dibuka
    $('#createPeriode').on('show.bs.modal', function () {
        $('#form-tambah-periode')[0].reset();
        $('.text-danger').empty();
    });

    // Auto-open modal jika ada error dari server (misal pada reload pertama)
    @if($errors->any())
        $(document).ready(function () {
            $('#createPeriode').modal('show');
        });
    @endif
</script>

