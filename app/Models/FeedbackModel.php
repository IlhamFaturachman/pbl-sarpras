<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'm_feedback';

    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'laporan_id',
        'rating',
        'komentar',
        'tanggal_feedback',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }
}
