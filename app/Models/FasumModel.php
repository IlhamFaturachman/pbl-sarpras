<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasumModel extends Model
{
    use HasFactory;

    protected $table = 'm_fasum'; 

    protected $primaryKey = 'fasum_id'; 

    protected $fillable = [
        'kode',
        'nama',
        'lokasi',
    ];
}
