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
        'ruang_id',
        'nama',
    ];

    public function ruang()
    {
        return $this->belongsTo(RuangModel::class, 'ruang_id', 'ruang_id');
    }
}
