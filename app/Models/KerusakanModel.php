<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KerusakanModel extends Model
{
    use HasFactory;

    protected $table = 'm_kerusakan';

    protected $primaryKey = 'kerusakan_id';

    protected $fillable = [
        'item_id',
        'fasum_id',
        'ruang_id',
        'deskripsi_kerusakan',
        'foto_kerusakan',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemModel::class, 'item_id', 'item_id');
    }

    public function fasum(): BelongsTo
    {
        return $this->belongsTo(FasumModel::class, 'fasum_id', 'fasum_id');
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(RuangModel::class, 'ruang_id', 'ruang_id');
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'pelapor_id', 'user_id');
    }
}
