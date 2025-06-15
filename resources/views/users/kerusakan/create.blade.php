<!-- Modal Create Kerusakan -->
<div class="modal fade" id="createKerusakanModal" tabindex="-1" aria-labelledby="createKerusakanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createKerusakanModalLabel">Tambah Data Kerusakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Step Indicator -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="step-indicator active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-text">Pilih Fasilitas</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-indicator" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-text">Detail Lokasi</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-indicator" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-text">Detail Kerusakan</div>
                    </div>
                </div>

                <form id="form-create" action="{{ route('kerusakan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Pilih Jenis Fasilitas -->
                    <div id="step-1" class="form-step">
                        <h6 class="mb-3">Pilih Jenis Fasilitas</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card facility-card" data-type="ruang">
                                    <div class="card-body text-center">
                                        <i class="fas fa-building fa-3x mb-3 text-primary"></i>
                                        <h6>Gedung & Ruangan</h6>
                                        <p class="text-muted small">Pilih fasilitas yang berada dalam gedung</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card facility-card" data-type="fasum">
                                    <div class="card-body text-center">
                                        <i class="fas fa-map-marker-alt fa-3x mb-3 text-success"></i>
                                        <h6>Fasilitas Umum</h6>
                                        <p class="text-muted small">Pilih fasilitas umum di area kampus</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="fasilitas_type" name="fasilitas_type" required>
                    </div>

                    <!-- Step 2: Detail Lokasi -->
                    <div id="step-2" class="form-step" style="display: none;">
                        <!-- Untuk Gedung & Ruangan -->
                        <div id="ruang-section" style="display: none;">
                            <h6 class="mb-3">Pilih Lokasi Gedung & Ruangan</h6>
                            <div class="mb-3">
                                <label for="gedung_id" class="form-label">Gedung <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="gedung_id" name="gedung_id">
                                    <option value="">Pilih Gedung</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ruang_id" class="form-label">Ruangan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="ruang_id" name="ruang_id" disabled>
                                    <option value="">Pilih gedung terlebih dahulu</option>
                                </select>
                            </div>
                        </div>

                        <!-- Untuk Fasilitas Umum -->
                        <div id="fasum-section" style="display: none;">
                            <h6 class="mb-3">Pilih Fasilitas Umum</h6>
                            <div class="mb-3">
                                <label for="fasum_id" class="form-label">Fasilitas Umum <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="fasum_id" name="fasum_id">
                                    <option value="">Pilih Fasilitas Umum</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Detail Kerusakan -->
                    <div id="step-3" class="form-step" style="display: none;">
                        <h6 class="mb-3">Detail Kerusakan</h6>
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Sarana <span class="text-danger">*</span></label>
                            <select class="form-select" id="item_id" name="item_id" required>
                                <option value="">Pilih Sarana</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_kerusakan" class="form-label">Deskripsi Kerusakan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="3"
                                placeholder="Jelaskan detail kerusakan..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto_kerusakan" class="form-label">
                                Foto Kerusakan <span class="text-danger">*</span>
                                <span id="foto-error" class="text-danger ms-2" style="font-size: 0.875em;"></span>
                            </label>
                            <input type="file" class="form-control" id="foto_kerusakan" name="foto_kerusakan"
                                accept="image/*" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-secondary" id="btn-prev"
                    style="display: none;">Sebelumnya</button>
                <button type="button" class="btn btn-primary" id="btn-next">Selanjutnya</button>
                <button type="button" class="btn btn-success" id="btn-submit"
                    style="display: none;">Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
    .facility-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e3e6f0;
    }

    .facility-card:hover {
        border-color: #4e73df;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transform: translateY(-2px);
    }

    .facility-card.selected {
        border-color: #4e73df;
        background-color: #f8f9fc;
    }

    .step-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e3e6f0;
        color: #858796;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .step-indicator.active .step-number {
        background-color: #4e73df;
        color: white;
    }

    .step-indicator.completed .step-number {
        background-color: #1cc88a;
        color: white;
    }

    .step-text {
        font-size: 12px;
        text-align: center;
        color: #858796;
    }

    .step-indicator.active .step-text {
        color: #4e73df;
        font-weight: bold;
    }

    .step-line {
        width: 80px;
        height: 2px;
        background-color: #e3e6f0;
        margin: 0 10px;
        align-self: flex-start;
        margin-top: 20px;
    }

    .step-indicator.completed+.step-line {
        background-color: #1cc88a;
    }

    /* Fix untuk SweetAlert2 z-index */
    .swal2-container {
        z-index: 99999 !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Tambahkan sebelum script kerusakan -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 3;

    // Facility card selection
    $('.facility-card').on('click', function() {
        $('.facility-card').removeClass('selected');
        $(this).addClass('selected');

        const facilityType = $(this).data('type');
        $('#fasilitas_type').val(facilityType);

        // Reset semua form step 2 dan 3
        resetFormSteps(facilityType);

        // Enable next button
        $('#btn-next').prop('disabled', false);
    });

    function resetFormSteps(facilityType) {
        // Reset step 2
        if (facilityType === 'ruang') {
            $('#fasum_id').val('').prop('disabled', true);
            $('#gedung_id').val('').prop('disabled', false);
            $('#ruang_id').val('').prop('disabled', true);
        } else {
            $('#gedung_id').val('').prop('disabled', true);
            $('#ruang_id').val('').prop('disabled', true);
            $('#fasum_id').val('').prop('disabled', false);
        }

        // Reset step 3
        $('#item_id').empty().append('<option value="">Pilih lokasi terlebih dahulu</option>');
        $('#deskripsi_kerusakan').val('');
        $('#foto_kerusakan').val('');

        // Jika sudah di step 2 atau 3, kembali ke step 1
        if (currentStep > 1) {
            currentStep = 1;
            showStep(currentStep);
        }
    }

    // Next button
    $('#btn-next').on('click', function() {
        if (validateCurrentStep()) {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);

                if (currentStep === 2) {
                    loadStep2Data();
                }

                if (currentStep === 3) {
                    loadStep3Data();
                }
            }
        }
    });

    // Previous button
    $('#btn-prev').on('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Submit button
    $('#btn-submit').on('click', function() {
        if (validateCurrentStep()) {
            submitForm();
        }
    });

    // Gedung change event
    $('#gedung_id').on('change', function() {
        const gedungId = $(this).val();
        
        // Reset ruang dan item dropdown
        $('#ruang_id').empty().append('<option value="">Pilih gedung terlebih dahulu</option>').prop('disabled', true);
        $('#item_id').empty().append('<option value="">Pilih ruangan terlebih dahulu</option>');
        
        if (gedungId) {
            $.ajax({
                url: "{{ url('users/kerusakan/ruang') }}/" + gedungId,
                type: 'GET',
                success: function(response) {
                    $('#ruang_id').empty().append('<option value="">Pilih Ruangan</option>');

                    response.ruangs.forEach(function(ruang) {
                        $('#ruang_id').append(
                            `<option value="${ruang.ruang_id}">${ruang.nama} (${ruang.kode})</option>`
                        );
                    });

                    $('#ruang_id').prop('disabled', false);
                },
                error: function() {
                    Swal.fire('Error', 'Gagal memuat data ruangan.', 'error');
                }
            });
        }
    });

    // Ruang change event - Load items berdasarkan ruang yang dipilih
    $('#ruang_id').on('change', function() {
        const ruangId = $(this).val();
        
        // Reset item dropdown
        $('#item_id').empty().append('<option value="">Pilih Sarana</option>');
        
        if (ruangId) {
            $.ajax({
                url: "{{ url('users/kerusakan/item-by-ruang') }}/" + ruangId,
                type: 'GET',
                success: function(response) {
                    $('#item_id').empty().append('<option value="">Pilih Sarana</option>');
                    
                    if (response.items && response.items.length > 0) {
                        response.items.forEach(function(item) {
                            $('#item_id').append(
                                `<option value="${item.item_id}">${item.nama}</option>`
                            );
                        });
                    } else {
                        $('#item_id').append('<option value="" disabled>Tidak ada sarana tersedia untuk ruangan ini</option>');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Gagal memuat data sarana.', 'error');
                }
            });
        }
    });

    // Fasum change event - Load items berdasarkan fasum yang dipilih
    $('#fasum_id').on('change', function() {
        const fasumId = $(this).val();
        
        // Reset item dropdown
        $('#item_id').empty().append('<option value="">Pilih Sarana</option>');
        
        if (fasumId) {
            $.ajax({
                url: "{{ url('users/kerusakan/item-by-fasum') }}/" + fasumId,
                type: 'GET',
                success: function(response) {
                    $('#item_id').empty().append('<option value="">Pilih Sarana</option>');
                    
                    if (response.items && response.items.length > 0) {
                        response.items.forEach(function(item) {
                            $('#item_id').append(
                                `<option value="${item.item_id}">${item.nama}</option>`
                            );
                        });
                    } else {
                        $('#item_id').append('<option value="" disabled>Tidak ada sarana tersedia untuk fasilitas ini</option>');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Gagal memuat data sarana.', 'error');
                }
            });
        }
    });

    function showStep(step) {
        // Hide all steps
        $('.form-step').hide();

        // Show current step
        $(`#step-${step}`).show();

        // Update step indicators
        $('.step-indicator').removeClass('active completed');

        for (let i = 1; i < step; i++) {
            $(`.step-indicator[data-step="${i}"]`).addClass('completed');
        }

        $(`.step-indicator[data-step="${step}"]`).addClass('active');

        // Update buttons
        $('#btn-prev').toggle(step > 1);
        $('#btn-next').toggle(step < totalSteps);
        $('#btn-submit').toggle(step === totalSteps);
    }

    function loadStep2Data() {
        const facilityType = $('#fasilitas_type').val();

        if (facilityType === 'ruang') {
            $('#fasum_id').val('').prop('disabled', true);
            $('#ruang-section').show();
            $('#fasum-section').hide();

            // Load gedung data
            if (window.modalData && window.modalData.gedungs) {
                $('#gedung_id').empty().append('<option value="">Pilih Gedung</option>');
                window.modalData.gedungs.forEach(function(gedung) {
                    $('#gedung_id').append(
                        `<option value="${gedung.gedung_id}">${gedung.nama} (${gedung.kode})</option>`
                    );
                });
            }
        } else if (facilityType === 'fasum') {
            $('#ruang_id').val('').prop('disabled', true);
            $('#gedung_id').val('').prop('disabled', true);
            $('#fasum-section').show();
            $('#ruang-section').hide();

            // Load fasum data
            if (window.modalData && window.modalData.fasums) {
                $('#fasum_id').empty().append('<option value="">Pilih Fasilitas Umum</option>');
                window.modalData.fasums.forEach(function(fasum) {
                    $('#fasum_id').append(
                        `<option value="${fasum.fasum_id}">${fasum.nama}</option>`
                    );
                });
            }
        }
    }

    function loadStep3Data() {
        // Reset item dropdown saat masuk ke step 3
        $('#item_id').empty().append('<option value="">Pilih lokasi terlebih dahulu</option>');
        
        // Jika sudah ada ruang atau fasum yang dipilih, load items nya
        const facilityType = $('#fasilitas_type').val();
        
        if (facilityType === 'ruang') {
            const ruangId = $('#ruang_id').val();
            if (ruangId) {
                // Trigger change event untuk load items
                $('#ruang_id').trigger('change');
            }
        } else if (facilityType === 'fasum') {
            const fasumId = $('#fasum_id').val();
            if (fasumId) {
                // Trigger change event untuk load items
                $('#fasum_id').trigger('change');
            }
        }
    }

    function validateCurrentStep() {
        if (currentStep === 1) {
            if (!$('#fasilitas_type').val()) {
                Swal.fire('Perhatian', 'Pilih jenis fasilitas terlebih dahulu.', 'warning');
                return false;
            }
        } else if (currentStep === 2) {
            const facilityType = $('#fasilitas_type').val();

            if (facilityType === 'ruang') {
                if (!$('#gedung_id').val() || !$('#ruang_id').val()) {
                    Swal.fire('Perhatian', 'Pilih gedung dan ruangan terlebih dahulu.', 'warning');
                    return false;
                }
            } else if (facilityType === 'fasum') {
                if (!$('#fasum_id').val()) {
                    Swal.fire('Perhatian', 'Pilih fasilitas umum terlebih dahulu.', 'warning');
                    return false;
                }
            }
        } else if (currentStep === 3) {
            if (!$('#item_id').val()) {
                Swal.fire('Perhatian', 'Pilih sarana terlebih dahulu.', 'warning');
                return false;
            }

            const deskripsi = $('#deskripsi_kerusakan').val().trim();
            if (!deskripsi) {
                Swal.fire('Perhatian', 'Deskripsi kerusakan tidak boleh kosong.', 'warning');
                return false;
            }

            const fotoKerusakan = $('#foto_kerusakan')[0].files;
            if (!fotoKerusakan || fotoKerusakan.length === 0) {
                Swal.fire('Perhatian', 'Mohon unggah foto kerusakan.', 'warning');
                return false;
            }
        }

        return true;
    }

    function submitForm() {
        // Disable submit button untuk mencegah double submit
        const submitBtn = $('#btn-submit');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Mengirim...');

        // Pastikan semua field yang tidak diperlukan tidak di-disabled
        const fasilitasType = $('#fasilitas_type').val();
        
        // Enable semua field sebelum submit
        $('#form-create input, #form-create select, #form-create textarea').prop('disabled', false);
        
        // Disable field yang tidak digunakan berdasarkan tipe fasilitas
        if (fasilitasType === 'ruang') {
            $('#fasum_id').prop('disabled', true).val('');
        } else if (fasilitasType === 'fasum') {
            $('#gedung_id').prop('disabled', true).val('');
            $('#ruang_id').prop('disabled', true).val('');
        }

        const formData = new FormData($('#form-create')[0]);

        // Debug: Log form data
        console.log('Form Data yang akan dikirim:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        $.ajax({
            url: $('#form-create').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // Show loading state
                console.log('Mengirim data ke server...');
            },
            success: function(response) {
                console.log('Response dari server:', response);
                
                if (response.success) {
                    $('#createKerusakanModal').modal('hide');
                    Swal.fire({
                        title: 'Berhasil',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message || 'Gagal menyimpan data kerusakan.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Debug Error Response dari Laravel:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText.substring(0, 500), // Limit untuk debugging
                    responseJSON: xhr.responseJSON,
                    errors: xhr.responseJSON?.errors,
                    actualError: error
                });

                let errorMessage = 'Gagal menyimpan data kerusakan.';
                let showDetails = false;

                // Parse error berdasarkan response
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.foto_kerusakan) {
                        errorMessage = errors.foto_kerusakan.join(', ');
                    } else {
                        errorMessage = Object.values(errors).map(err => 
                            Array.isArray(err) ? err.join(', ') : err
                        ).join('\n');
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMessage = 'Terjadi kesalahan pada server. Periksa konfigurasi atau log Laravel.';
                    showDetails = true;
                    
                    // Coba extract error dari HTML response
                    if (xhr.responseText.includes('FatalErrorException') || 
                        xhr.responseText.includes('ErrorException') ||
                        xhr.responseText.includes('FatalError')) {
                        
                        // Extract error message dari HTML jika memungkinkan
                        const errorMatch = xhr.responseText.match(/<h1[^>]*>(.*?)<\/h1>/);
                        if (errorMatch && errorMatch[1]) {
                            errorMessage += '\n\nDetail: ' + errorMatch[1].replace(/&quot;/g, '"');
                        }
                    }
                } else if (xhr.status === 404) {
                    errorMessage = 'URL tidak ditemukan. Periksa route di web.php';
                } else if (xhr.status === 0) {
                    errorMessage = 'Tidak dapat terhubung ke server. Periksa koneksi internet.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Data tidak valid. Periksa semua field yang diperlukan.';
                }

                // Tampilkan error dengan opsi untuk melihat detail
                if (showDetails && xhr.responseText.length > 100) {
                    Swal.fire({
                        title: 'Error Server',
                        text: errorMessage,
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonText: 'Lihat Detail Error',
                        cancelButtonText: 'Tutup',
                        confirmButtonColor: '#dc3545'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buka window baru dengan error detail
                            const errorWindow = window.open('', '_blank');
                            errorWindow.document.write(xhr.responseText);
                        }
                    });
                } else {
                    Swal.fire('Error', errorMessage, 'error');
                }
            },
            complete: function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    }

    // Reset form ketika modal ditutup
    $('#createKerusakanModal').on('hidden.bs.modal', function () {
        $('#form-create')[0].reset();
        currentStep = 1;
        showStep(currentStep);
        $('.facility-card').removeClass('selected');
        $('#fasilitas_type').val('');
        $('#btn-next').prop('disabled', false);
    });
});
</script>