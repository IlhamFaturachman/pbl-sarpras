<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="feedbackForm" method="POST" action="{{ route('feedback.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-white">
                    <h5 class="modal-title" id="feedbackModalLabel">Berikan Penilaian Anda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="laporan_id" id="laporan_id">
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->user_id }}">

                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold mb-3">Bagaimana penilaian Anda?</label>
                            <div class="rating-stars">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="d-none">
                                    <label for="star{{ $i }}" class="star-label">
                                        <i class="fas fa-star fa-2x"></i>
                                    </label>
                                @endfor
                            </div>
                        <small class="text-muted d-block mt-1">Pilih 1-5 bintang</small>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label fw-bold">Komentar</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="4" required 
                                  placeholder="Berikan komentar atau saran Anda..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Penilaian
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Meta tag untuk CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .rating-stars {
        display: flex;
        justify-content: center;
        flex-direction: row-reverse; 
        gap: 8px;
    }
    .star-label {
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    .rating-stars input:checked ~ label,
    .rating-stars input:checked ~ label ~ label {
        color: #ffc107;
    }
    .rating-stars input:checked + label {
        color: #ffc107;
    }
    .star-label:hover,
    .star-label:hover ~ .star-label {
        color: #ffc107;
    }
</style>
