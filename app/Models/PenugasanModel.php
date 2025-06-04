<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenugasanModel extends Model
{
    use HasFactory;

    protected $table = 'm_penugasan'; 

    protected $primaryKey = 'penugasan_id'; 

    protected $fillable = [
        'laporan_id',
        'teknisi_id',
        'status_penugasan',
        'tanggal_mulai',
        'tanggal_selesai',
        'bukti_perbaikan',
        'catatan_perbaikan',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'teknisi_id', 'user_id');
    }
}
