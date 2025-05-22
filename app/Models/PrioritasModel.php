<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrioritasModel extends Model
{
    use HasFactory;

    protected $table = 'm_prioritas'; 

    protected $primaryKey = 'prioritas_id'; 

    protected $fillable = [
        'laporan_id',
        'tingkat_kerusakan',
        'dampak',
        'jumlah_terdampak',
        'alternatif',
        'ancaman',
        'skor_laporan',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }
}
