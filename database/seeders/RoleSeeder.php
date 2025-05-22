<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\UserModel;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'mahasiswa',
            'dosen',
            'tendik',
            'sarpras',
            'teknisi',
        ];

        // Buat role jika belum ada
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Mapping email ke role
        $userRoles = [
            'admin@example.com' => 'admin',
            'mahasiswa@example.com' => 'mahasiswa',
            'dosen@example.com' => 'dosen',
            'tendik@example.com' => 'tendik',
            'sarpras@example.com' => 'sarpras',
            'teknisi@example.com' => 'teknisi',
        ];

        // Assign role ke user berdasarkan email
        foreach ($userRoles as $email => $roleName) {
            $user = UserModel::where('email', $email)->first();
            if ($user) {
                $user->assignRole($roleName);
            }
        }
    }
}
