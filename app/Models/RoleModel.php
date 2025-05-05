<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class RoleModel extends SpatieRole
{
    protected $table = 'm_role'; // Tabel custom kamu

    protected $primaryKey = 'id'; // Pastikan ini sesuai. Biasanya tetap 'id'

    protected $fillable = [
        'name',
        'guard_name',
    ];
}
