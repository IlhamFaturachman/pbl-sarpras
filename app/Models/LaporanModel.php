<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanModel extends Model
{
    use HasFactory;

    protected $table = 'm_laporan'; 

    protected $primaryKey = 'laporan_id'; 

    protected $fillable = [
        'pelapor_id',
        'kerusakan_id',
        'status_laporan',
        'prioritas',
        'tanggal_laporan',
        'tanggal_update',
        'periode_id'
    ];

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'pelapor_id', 'user_id');
    }

    public function kerusakan(): BelongsTo
    {
        return $this->belongsTo(KerusakanModel::class, 'kerusakan_id', 'kerusakan_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }

    public function prioritas()
    {
        return $this->hasOne(PrioritasModel::class, 'laporan_id', 'laporan_id');
    }

    public function penugasan()
    {
        return $this->hasOne(PenugasanModel::class, 'laporan_id', 'laporan_id');
    }
    
    public function feedback()
    {
        return $this->hasOne(FeedbackModel::class, 'laporan_id', 'laporan_id');
    }
}
