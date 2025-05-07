<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\UserModel;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole = Role::firstOrCreate(['name' => 'mahasiswa']);
        $adminRole = Role::firstOrCreate(['name' => 'dosen']);
        $adminRole = Role::firstOrCreate(['name' => 'tendik']);
        $adminRole = Role::firstOrCreate(['name' => 'sarpras']);
        $adminRole = Role::firstOrCreate(['name' => 'teknisi']);

        // Ambil user yang tadi dibuat
        $user = UserModel::where('email', 'admin@example.com')->first();

        // Assign role ke user
        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
