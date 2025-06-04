<!-- Modal Edit Item -->
<div class="modal fade" id="editItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-edit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error Container -->
                    <div id="edit-error-container" class="alert alert-danger" style="display: none;">
                        <ul id="edit-error-list"></ul>
                    </div>

                    <!-- Data Item -->
                    <div class="row">
                        <!-- Pilih Gedung -->
                        <div class="col mb-3">
                            <label for="edit_gedung_id" class="form-label">Pilih Gedung</label>
                            <select id="edit_gedung_id" name="gedung_id" class="form-select" required>
                                <option value="">-- Pilih Gedung --</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Pilih Ruang -->
                        <div class="col mb-3">
                            <label for="edit_ruang_id" class="form-label">Pilih Ruang</label>
                            <select id="edit_ruang_id" name="ruang_id" class="form-select" required>
                                <option value="">-- Pilih Ruang --</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Nama Item -->
                        <div class="col mb-3">
                            <label for="edit_nama" class="form-label">Nama Item</label>
                            <input type="text" id="edit_nama" name="nama" class="form-control" placeholder="Masukkan Nama Item" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function untuk menampilkan modal edit
    function editItem(id) {
        $.ajax({
            url: `{{ url('/admin/data/item') }}/${id}/edit`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const item = response.item;
                const gedungs = response.gedungs;
                const ruangs = response.ruangs;
                
                // Set form action
                $('#form-edit').attr('action', `{{ url('/admin/data/item') }}/${id}`);
                
                // Populate gedung dropdown
                let gedungOptions = '<option value="">-- Pilih Gedung --</option>';
                gedungs.forEach(function(gedung) {
                    const selected = gedung.gedung_id == item.ruang.gedung_id ? 'selected' : '';
                    gedungOptions += `<option value="${gedung.gedung_id}" ${selected}>${gedung.nama}</option>`;
                });
                $('#edit_gedung_id').html(gedungOptions);
                
                // Populate ruang dropdown
                let ruangOptions = '<option value="">-- Pilih Ruang --</option>';
                ruangs.forEach(function(ruang) {
                    const selected = ruang.ruang_id == item.ruang_id ? 'selected' : '';
                    ruangOptions += `<option value="${ruang.ruang_id}" ${selected}>${ruang.nama}</option>`;
                });
                $('#edit_ruang_id').html(ruangOptions);
                
                // Set item name
                $('#edit_nama').val(item.nama);
                
                // Show modal
                $('#editItem').modal('show');
                
                // Hide error container
                $('#edit-error-container').hide();
            },
            error: function() {
                alert('Gagal mengambil data item');
            }
        });
    }

    // Event handler untuk perubahan gedung di form edit
    $('#edit_gedung_id').on('change', function() {
        const gedungId = $(this).val();
        const ruangSelect = $('#edit_ruang_id');
        
        if (gedungId) {
            loadRuangForEdit(gedungId);
        } else {
            ruangSelect.html('<option value="">-- Pilih Ruang --</option>');
        }
    });

    // Function untuk load ruang di form edit
    function loadRuangForEdit(gedungId, selectedRuangId = null) {
        const ruangSelect = $('#edit_ruang_id');
        
        $.ajax({
            url: `{{ url('/admin/item/get-ruang') }}/${gedungId}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                ruangSelect.html('<option value="">Loading...</option>');
            },
            success: function(data) {
                let options = '<option value="">-- Pilih Ruang --</option>';
                
                $.each(data, function(index, ruang) {
                    const selected = selectedRuangId && selectedRuangId == ruang.ruang_id ? 'selected' : '';
                    options += `<option value="${ruang.ruang_id}" ${selected}>${ruang.nama}</option>`;
                });
                
                ruangSelect.html(options);
            },
            error: function() {
                ruangSelect.html('<option value="">Error loading ruang</option>');
            }
        });
    }

    // Auto-open edit modal jika ada error dari server
    @if($errors->any() && session('editing'))
        $(document).ready(function () {
            // Jika ada error saat editing, buka modal edit
            // Anda perlu menyimpan ID item yang sedang diedit di session
            @if(session('editing_item_id'))
                editItem({{ session('editing_item_id') }});
            @endif
        });
    @endif
</script>