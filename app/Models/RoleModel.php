<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class RoleModel extends SpatieRole
{
    protected $table = 'm_role'; 

    protected $primaryKey = 'id'; 

    protected $fillable = [
        'name',
        'guard_name',
    ];
}
