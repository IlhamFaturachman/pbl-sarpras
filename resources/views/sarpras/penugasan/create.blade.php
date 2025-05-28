<form method="POST" id="form-assign" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="assignPenugasan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Penugasan Perbaikan</h5>
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
                            <label for="teknisi" class="form-label">Nama Teknisi</label>                            
                            <select id="teknisi" name="teknisi" class="form-select" required>
                                <option value="">-- Pilih Nama Teknisi --</option>
                                @foreach($teknisis as $teknisi)
                                    <option value="{{ $teknisi->user_id }}" {{ old('teknisi') == $teknisi->user_id ? 'selected' : '' }}>
                                        {{ $teknisi->nama }}
                                    </option>
                                @endforeach
                            </select>
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
    // Reset form saat modal dibuka
    $('#createPenugasan').on('show.bs.modal', function () {
        $('#form-assign')[0].reset();
        $('.text-danger').html('');
    });

    // Auto-open modal jika ada error dari server
    @if($errors->any())
        $(document).ready(function () {
            $('#createPenugasan').modal('show');
        });
    @endif
</script>
