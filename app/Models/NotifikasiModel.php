<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LaporanModel;

class NotifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'm_notifikasi';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'laporan_id',
        'isi_notifikasi',
        'is_read',
    ];

    public $timestamps = false;

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
