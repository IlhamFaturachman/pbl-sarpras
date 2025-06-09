<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'm_user'; 
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama_lengkap',
        'nomor_induk',
        'nama',
        'email',
        'password',
        'identitas',
        'status',
        'foto_profile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
