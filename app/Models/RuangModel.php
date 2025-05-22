<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuangModel extends Model
{
    use HasFactory;

    protected $table = 'm_ruang'; 

    protected $primaryKey = 'ruang_id'; 

    protected $fillable = [
        'nama',
        'kode',
        'gedung_id',
        'lantai',
    ];

    public function gedung(): BelongsTo
    {
        return $this->belongsTo(GedungModel::class, 'gedung_id', 'gedung_id');
    }
}
