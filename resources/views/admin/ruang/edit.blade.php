<form action="{{ route('ruang.update', $ruang->ruang_id) }}" method="POST" id="form-edit" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editRuang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Data Ruang</h5>
                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
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
                    
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_kode" class="form-label">Kode Ruang</label>
                            <input type="text" id="edit_kode" name="kode" class="form-control" placeholder="Masukkan Kode Ruang" required value="{{ old('kode', $editRuang->kode) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_nama" class="form-label">Nama Ruang</label>
                            <input type="text" id="edit_nama" name="nama" class="form-control" placeholder="Masukkan Nama Ruang" required value="{{ old('nama', $editRuang->nama) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_gedung" class="form-label">Nama Gedung</label>
                            <select id="edit_gedung" name="gedung" class="form-select" required>
                                <option value="">-- Pilih Nama Gedung --</option>
                                @foreach($gedungs as $gedung)
                                    <option value="{{ $gedung->gedung_id }}" {{ (old('gedung', $editRuang->gedung_id ?? '') == $gedung->gedung_id) ? 'selected' : '' }}>{{ $gedung->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="edit_lantai" class="form-label">Lantai</label>
                            <input type="number" id="edit_lantai" name="lantai" class="form-control" placeholder="Masukkan Lantai" required value="{{ old('lantai', $editRuang->lantai) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"> Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>    
    // Auto-open modal if there are validation errors for edit form
    @if($errors->any() && session('editing'))
        $(document).ready(function() {
            $('#editRuang').modal('show');
        });
    @endif
</script>