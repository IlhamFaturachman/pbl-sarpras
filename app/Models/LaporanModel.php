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

    public $incrementing = false; 
    
    protected $keyType = 'string';

    protected $fillable = [
        'pelapor_id',
        'verifikator_id',
        'kerusakan_id',
        'status_laporan',
        'tanggal_laporan',
        'tanggal_update_status',
        'periode_id'
    ];

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'verifikator_id', 'user_id');
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
