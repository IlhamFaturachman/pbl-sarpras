<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    use HasFactory;

    protected $table = 'm_item'; 

    protected $primaryKey = 'item_id'; 

    protected $fillable = [
        'nama', 
        'ruang_id', 
        'fasum_id'
    ];

    public function ruang()
    {
        return $this->belongsTo(RuangModel::class, 'ruang_id', 'ruang_id');
    }

    public function fasum() {
        return $this->belongsTo(FasumModel::class, 'fasum_id', 'fasum_id');
    }
}
