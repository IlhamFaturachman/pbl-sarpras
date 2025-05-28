<form method="POST" id="form-confirm" enctype="multipart/form-data" action="">
    @csrf
    <input type="hidden" name="laporan_id" id="input_laporan_id" value="">

    <div class="modal fade" id="confirmPenugasan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Perbaikan Kerusakan Fasilitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    {{-- Error display --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body pt-3">
                        <div class="row">
                            <!-- Kiri -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <div class="fw-semibold">Tanggal Mulai Perbaikan</div>
                                    <div class="mt-1" id="confirm_tanggal_mulai"></div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-semibold">Tanggal Selesai Perbaikan</div>
                                    <div class="mt-1" id="confirm_tanggal_selesai"></div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-semibold">Nama Teknisi</div>
                                    <div class="mt-1" id="confirm_teknisi"></div>
                                </div>
                                <div class="mb-3">
                                    <div class="fw-semibold">Catatan Perbaikan</div>
                                    <div class="mt-1" id="confirm_catatan_perbaikan"></div>
                                </div>
                            </div>

                            <!-- Kanan -->
                            <div class="col-md-4">
                                <div class="fw-semibold mb-2">Bukti Perbaikan</div>
                                <img id="confirm_bukti_perbaikan" class="img-fluid rounded shadow-sm" width="240px" />
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Konfirmasi -->
                    <div class="mb-3">
                        <label class="form-label d-block">Pilih Konfirmasi</label>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="konfirmasi" id="konfirmasi_selesai" value="Selesai" {{ old('konfirmasi') === 'Selesai' ? 'checked' : '' }}>
                            <label class="form-check-label" for="konfirmasi_selesai">Selesai</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="konfirmasi" id="konfirmasi_revisi" value="Revisi" {{ old('konfirmasi') === 'Revisi' ? 'checked' : '' }}>
                            <label class="form-check-label" for="konfirmasi_revisi">Revisi</label>
                        </div>
                    </div>

                    <div class="mb-3" id="catatan-group">
                        <label for="catatan_perbaikan" class="form-label">Catatan Perbaikan</label>
                        <input type="text" id="catatan_perbaikan" name="catatan_perbaikan" class="form-control"
                            placeholder="Masukkan catatan perbaikan jika memilih 'Revisi'" value="{{ old('catatan_perbaikan') }}">
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
    document.addEventListener('DOMContentLoaded', function () {
        const formConfirm = document.getElementById('form-confirm');
        const modalEl = document.getElementById('confirmPenugasan');
        const bootstrapModal = new bootstrap.Modal(modalEl);

        function updateCatatanRequired() {
            const konfirmasi = formConfirm.querySelector('input[name="konfirmasi"]:checked');
            const catatanInput = document.getElementById('catatan_perbaikan');

            if (konfirmasi && konfirmasi.value === 'Revisi') {
                catatanInput.setAttribute('required', 'required');
            } else {
                catatanInput.removeAttribute('required');
            }
        }

        // Show modal if errors exist (validation failed)
        @if ($errors->any())
            bootstrapModal.show();
        @endif

        // When modal is shown, reset form only if no errors
        modalEl.addEventListener('show.bs.modal', function () {
            @if (!$errors->any())
                formConfirm.reset();
            @endif
            updateCatatanRequired();
        });

        // Update required on konfirmasi radio change
        formConfirm.querySelectorAll('input[name="konfirmasi"]').forEach(function (input) {
            input.addEventListener('change', updateCatatanRequired);
        });
    });
</script>
