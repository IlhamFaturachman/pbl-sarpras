<div class="modal fade" id="editItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-edit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Sarana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error Container -->
                    <div id="edit-error-container" class="alert alert-danger" style="display: none;">
                        <ul id="edit-error-list"></ul>
                    </div>

                    <!-- Form untuk Gedung/Ruang -->
                    <div id="edit-form-gedung" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_gedung_id" class="form-label">Pilih Gedung</label>
                                <select id="edit_gedung_id" name="gedung_id" class="form-select">
                                    <option value="">-- Pilih Gedung --</option>
                                    @foreach($gedungs as $gedung)
                                        <option value="{{ $gedung->gedung_id }}">
                                            {{ $gedung->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_ruang_id" class="form-label">Pilih Ruang</label>
                                <select id="edit_ruang_id" name="ruang_id" class="form-select" disabled>
                                    <option value="">-- Pilih Ruang --</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_nama_item_ruang" class="form-label">Nama Sarana</label>
                                <input type="text" id="edit_nama_item_ruang" name="nama_item_ruang" class="form-control" placeholder="Masukkan Nama Sarana">
                            </div>
                        </div>
                        <input type="hidden" name="location_type" value="gedung">
                    </div>

                    <!-- Form untuk Fasilitas Umum -->
                    <div id="edit-form-fasum" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_fasum_id" class="form-label">Pilih Fasilitas Umum</label>
                                <select id="edit_fasum_id" name="fasum_id" class="form-select">
                                    <option value="">-- Pilih Fasilitas Umum --</option>
                                    @foreach($fasums as $fasum)
                                        <option value="{{ $fasum->fasum_id }}">
                                            {{ $fasum->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_nama_item_fasum" class="form-label">Nama Item</label>
                                <input type="text" id="edit_nama_item_fasum" name="nama_item_fasum" class="form-control" placeholder="Masukkan Nama Item">
                            </div>
                        </div>
                        <input type="hidden" name="location_type" value="fasum">
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
    function editItem(id) {
        $.ajax({
            url: `{{ url('/admin/data/item') }}/${id}/edit`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const item = response.item;
                const ruangs = response.ruangs;
                
                // Set form action
                $('#form-edit').attr('action', `{{ url('/admin/data/item') }}/${id}`);
                
                // Reset form
                $('#edit-form-gedung, #edit-form-fasum').hide();
                
                if (item.ruang_id) {
                    // Item di gedung/ruang
                    $('#edit_gedung_id').val(item.ruang.gedung_id);
                    $('#edit_nama_item_ruang').val(item.nama);
                    $('input[name="location_type"]').val('gedung');
                    
                    // Populate ruang dropdown
                    let ruangOptions = '<option value="">-- Pilih Ruang --</option>';
                    ruangs.forEach(function(ruang) {
                        const selected = ruang.ruang_id == item.ruang_id ? 'selected' : '';
                        ruangOptions += `<option value="${ruang.ruang_id}" ${selected}>${ruang.nama}</option>`;
                    });
                    $('#edit_ruang_id').html(ruangOptions).prop('disabled', false);
                    
                    $('#edit-form-gedung').show();
                } else {
                    // Item di fasilitas umum
                    $('#edit_fasum_id').val(item.fasum_id);
                    $('#edit_nama_item_fasum').val(item.nama);
                    $('input[name="location_type"]').val('fasum');
                    
                    $('#edit-form-fasum').show();
                }
                
                // Hide error container
                $('#edit-error-container').hide();
                
                // Show modal
                $('#editItem').modal('show');
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
            ruangSelect.prop('disabled', true)
                     .html('<option value="">-- Pilih Ruang --</option>');
        }
    });

    // Function untuk load ruang di form edit
    function loadRuangForEdit(gedungId, selectedRuangId = null) {
        const ruangSelect = $('#edit_ruang_id');
        
        $.ajax({
            url: `{{ url('/admin/data/item/get-ruang') }}/${gedungId}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                ruangSelect.prop('disabled', true)
                           .html('<option value="">Loading...</option>');
            },
            success: function(response) {
                let options = '<option value="">-- Pilih Ruang --</option>';
                
                if (response && response.length > 0) {
                    $.each(response, function(index, ruang) {
                        const selected = (selectedRuangId && selectedRuangId == ruang.ruang_id) ? 
                                       'selected' : '';
                        options += `<option value="${ruang.ruang_id}" ${selected}>${ruang.nama}</option>`;
                    });
                    ruangSelect.prop('disabled', false);
                } else {
                    options = '<option value="">Tidak ada ruang tersedia</option>';
                }
                
                ruangSelect.html(options);
            },
            error: function() {
                ruangSelect.html('<option value="">Error loading ruang</option>');
            }
        });
    }

    // Form submission handling
    $('#form-edit').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const url = form.attr('action');
        const formData = form.serialize();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    $('#editItem').modal('hide');
                    Swal.fire({
                        title: "Berhasil",
                        text: response.message,
                        icon: "success",
                        timer: 3000
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorHtml = '';
                    
                    $.each(errors, function(key, value) {
                        errorHtml += `<li>${value[0]}</li>`;
                    });
                    
                    $('#edit-error-list').html(errorHtml);
                    $('#edit-error-container').show();
                    
                    // Scroll to error container
                    $('.modal-body').animate({
                        scrollTop: $('#edit-error-container').offset().top - 20
                    }, 500);
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });

    @if($errors->any() && session('editing'))
        $(document).ready(function () {
            @if(session('editing_item_id'))
                editItem({{ session('editing_item_id') }});
                
                // Set values from old input
                const locationType = "{{ old('location_type', 'gedung') }}";
                
                if(locationType === 'gedung') {
                    $('#edit_gedung_id').val("{{ old('gedung_id') }}");
                    $('#edit_nama_item_ruang').val("{{ old('nama_item_ruang') }}");
                    
                    @if(old('gedung_id'))
                        loadRuangForEdit("{{ old('gedung_id') }}", "{{ old('ruang_id') }}");
                    @endif
                    
                    $('#edit-form-gedung').show();
                } else {
                    $('#edit_fasum_id').val("{{ old('fasum_id') }}");
                    $('#edit_nama_item_fasum').val("{{ old('nama_item_fasum') }}");
                    
                    $('#edit-form-fasum').show();
                }
                
                // Show errors
                let errorHtml = '';
                @foreach($errors->all() as $error)
                    errorHtml += `<li>{{ $error }}</li>`;
                @endforeach
                $('#edit-error-list').html(errorHtml);
                $('#edit-error-container').show();
            @endif
        });
    @endif
</script>