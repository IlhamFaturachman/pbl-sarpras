@php
$storeRoute = auth()->user()->hasRole('admin') ? 'data.item.store' : 'sarana.item.store';
@endphp
<form action="{{ route($storeRoute) }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="createItem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Data Sarana</h5>
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

                    <!-- Step 1: Pilih Jenis Lokasi -->
                    <div id="step1" class="step-content">
                        <h6 class="mb-3">Pilih Jenis Lokasi:</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <button type="button" class="btn btn-outline-primary w-100 location-type" data-type="gedung">
                                    <i class="bx bx-building me-1"></i> Gedung/Ruang
                                </button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button type="button" class="btn btn-outline-success w-100 location-type" data-type="fasum">
                                    <i class="bx bx-map me-1"></i> Fasilitas Umum
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2a: Form untuk Gedung/Ruang -->
                    <div id="step2-gedung" class="step-content" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Tambah Sarana di Gedung/Ruang</h6>
                            <button type="button" class="btn btn-sm btn-label-secondary back-to-step1">
                                <i class="bx bx-chevron-left me-1"></i> Kembali
                            </button>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="gedung_id" class="form-label">Pilih Gedung</label>
                                <select id="gedung_id" name="gedung_id" class="form-select">
                                    <option value="">-- Pilih Gedung --</option>
                                    @foreach($gedungs as $gedung)
                                    <option value="{{ $gedung->gedung_id }}" {{ old('gedung_id') == $gedung->gedung_id ? 'selected' : '' }}>
                                        {{ $gedung->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="ruang_id" class="form-label">Pilih Ruang</label>
                                <select id="ruang_id" name="ruang_id" class="form-select" disabled>
                                    <option value="">-- Pilih Ruang --</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama_item_ruang" class="form-label">Nama Sarana</label>
                                <input type="text" id="nama_item_ruang" name="nama_item_ruang" class="form-control" placeholder="Masukkan Nama Sarana" value="{{ old('nama') }}">
                            </div>
                        </div>
                        <input type="hidden" name="location_type" value="gedung">
                    </div>

                    <!-- Step 2b: Form untuk Fasilitas Umum -->
                    <div id="step2-fasum" class="step-content" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Tambah Sarana di Fasilitas Umum</h6>
                            <button type="button" class="btn btn-sm btn-label-secondary back-to-step1">
                                <i class="bx bx-chevron-left me-1"></i> Kembali
                            </button>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="fasum_id" class="form-label">Pilih Fasilitas Umum</label>
                                <select id="fasum_id" name="fasum_id" class="form-select">
                                    <option value="">-- Pilih Fasilitas Umum --</option>
                                    @foreach($fasums as $fasum)
                                    <option value="{{ $fasum->fasum_id }}" {{ old('fasum_id') == $fasum->fasum_id ? 'selected' : '' }}>
                                        {{ $fasum->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama_item_fasum" class="form-label">Nama Sarana</label>
                                <input type="text" id="nama_item_fasum" name="nama_item_fasum" class="form-control" placeholder="Masukkan Nama Sarana" value="{{ old('nama') }}">
                            </div>
                        </div>
                        <input type="hidden" name="location_type" value="fasum">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit-button" style="display: none;">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    jQuery(document).ready(function($) {
        // Setup CSRF token untuk AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle klik tombol jenis lokasi
        $('.location-type').on('click', function() {
            const type = $(this).data('type');

            // Update nilai input hidden
            $('input[name="location_type"]').val(type);

            // Sembunyikan semua step content
            $('.step-content').hide();

            // Tampilkan step 2 sesuai pilihan
            $('#step2-' + type).show();

            // Tampilkan tombol submit
            $('#submit-button').show();
        });

        // Handle tombol kembali ke step 1
        $('.back-to-step1').on('click', function() {
            $('.step-content').hide();
            $('#step1').show();
            $('#submit-button').hide();
        });

        // Event handler untuk perubahan gedung
        $('#gedung_id').on('change', function() {
            const gedungId = $(this).val();

            if (gedungId) {
                loadRuangByGedung(gedungId);
            } else {
                $('#ruang_id').prop('disabled', true)
                    .html('<option value="">-- Pilih Ruang --</option>');
            }
        });

        // DEBUG: Tambahkan event listener untuk form submit
        $('#form-tambah').on('submit', function(e) {
            const locationType = $('input[name="location_type"]').val();
            let isValid = true;

            if (locationType === 'fasum') {
                if (!$('#fasum_id').val()) {
                    alert('Pilih fasilitas umum terlebih dahulu');
                    isValid = false;
                }
                if (!$('#nama_item_fasum').val()) {
                    alert('Isi nama item terlebih dahulu');
                    isValid = false;
                }
            } else if (locationType === 'gedung') {
                if (!$('#gedung_id').val() || !$('#ruang_id').val()) {
                    alert('Pilih gedung dan ruang terlebih dahulu');
                    isValid = false;
                }
                if (!$('#nama_item_ruang').val()) {
                    alert('Isi nama item terlebih dahulu');
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
                // Tampilkan step yang sesuai jika validasi gagal
                if (locationType) {
                    $('.step-content').hide();
                    $('#step2-' + locationType).show();
                }
            }
        });

        function loadRuangByGedung(gedungId, selectedRuangId = null) {
            const ruangSelect = $('#ruang_id');

            const userRole = "{{ Auth::user()->getRoleNames()->first() }}";
            const baseUrl = userRole === 'sarpras' ?
                '/sarpras/sarana/item/get-ruang/' :
                '/admin/data/item/get-ruang/';

            $.ajax({
                url: baseUrl + gedungId,
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
                error: function(xhr, status, error) {
                    console.error("Error AJAX:", status, error);
                    console.error("Response:", xhr.responseText);
                    ruangSelect.html('<option value="">Error loading ruang</option>');
                }
            });
        }

        // Debug untuk error handling
        @if($errors->any())
        console.log('Ada errors:', @json($errors->all()));
        @if(old('location_type') == 'gedung')
        console.log('Restoring gedung form state');
        $('#step1').hide();
        $('#step2-gedung').show();
        $('#submit-button').show();
        @if(old('gedung_id'))
        loadRuangByGedung({
            {
                old('gedung_id')
            }
        }, {
            {
                old('ruang_id', 0)
            }
        });
        @endif
        @elseif(old('location_type') == 'fasum')
        console.log('Restoring fasum form state');
        $('#step1').hide();
        $('#step2-fasum').show();
        $('#submit-button').show();
        @endif

        // Scroll ke modal untuk melihat error
        $('html, body').animate({
            scrollTop: $('#createItem').offset().top
        }, 500);
        @endif
    });
</script>