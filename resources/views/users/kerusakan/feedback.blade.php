<!-- Modal Feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="feedbackForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Kirim Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="laporan_id" id="laporan_id">
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-select" required>
                            <option value="">Pilih rating</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Buka modal dan isi laporan_id secara dinamis
        $('.btn-feedback').on('click', function () {
            const laporanId = $(this).data('laporan-id');
            $('#laporan_id').val(laporanId);
            $('#feedbackModal').modal('show');
        });

        // Submit form feedback
        $('#feedbackForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('feedback.store') }}", // sesuaikan dengan rute penyimpanan
                method: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#feedbackModal').modal('hide');
                        $('#feedbackForm')[0].reset();
                    } else {
                        alert("Terjadi kesalahan: " + response.message);
                    }
                },
                error: function (xhr) {
                    alert("Gagal mengirim feedback: " + xhr.responseJSON.message);
                }
            });
        });
    });
</script>