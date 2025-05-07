<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::create([
            'nama_lengkap' => 'Admin Admin',
            'nomor_induk' => '1234567890',
            'nama' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), 
            'status' => 'aktif',
            'foto_profile' => 'default.jpg',
        ]);
    }
}
