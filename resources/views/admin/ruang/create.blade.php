<form action="{{ route('ruang.store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="createRuang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Data Ruang</h5>
                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error handling dari Laravel validation -->
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
                            <label for="kode" class="form-label">Kode Ruang</label>
                            <input type="text" id="kode" name="kode" class="form-control" placeholder="Masukkan Kode Ruang" required value="{{ old('kode') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Nama Ruang</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Ruang" required value="{{ old('nama') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="lantai" class="form-label">Lantai</label>
                            <input type="number" id="lantai" name="lantai" class="form-control" placeholder="Masukkan Lantai" required value="{{ old('lantai') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="gedung" class="form-label">Nama Gedung</label>
                            <select id="gedung" name="gedung" class="form-select" required>
                                <option value="">-- Pilih Nama Gedung --</option>
                                @foreach($gedungs as $gedung)
                                    <option value="{{ $gedung->gedung_id }}" {{ old('gedung') == $gedung->gedung_id ? 'selected' : '' }}>{{ $gedung->nama }}</option>
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
    $('#createRuang').on('show.bs.modal', function () {
        $('#form-tambah')[0].reset();
        $('.text-danger').html('');
    });

    // Auto-open modal jika ada error dari server (misal pada reload pertama)
    @if($errors->any())
        $(document).ready(function () {
            $('#createRuang').modal('show');
        });
    @endif
</script>