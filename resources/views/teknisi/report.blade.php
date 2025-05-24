<form method="POST" id="form-report" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="reportPenugasan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Laporan Perbaikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col mb-3">
                            <label for="bukti_perbaikan" class="form-label">Bukti Perbaikan (Foto)</label>
                            <input type="file" id="bukti_perbaikan" name="bukti_perbaikan" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: jpg, jpeg, png</small>

                            <img id="preview-image" style="max-width: 100%; margin-top: 10px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Preview image sebelum upload
    $('#bukti_perbaikan').on('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => $('#preview-image').attr('src', e.target.result);
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Reset form saat modal dibuka
    $('#reportPenugasan').on('show.bs.modal', function () {
        $('#form-tambah')[0].reset();
        $('.text-danger').html('');
    });

    // Auto-open modal jika ada error dari server
    @if($errors->any())
        $(document).ready(function () {
            $('#reportPenugasan').modal('show');
        });
    @endif
</script>
