<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama_lengkap' => 'Admin Admin',
                'nomor_induk' => '1234567890',
                'nama' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'status' => 'Aktif',
                'foto_profile' => 'default.jpg',
            ],
            [
                'nama_lengkap' => 'Mahasiswa Satu',
                'nomor_induk' => '2022010001',
                'nama' => 'Mahasiswa',
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('password'),
                'status' => 'Aktif',
                'foto_profile' => 'default.jpg',
            ],
            [
                'nama_lengkap' => 'Dosen Utama',
                'nomor_induk' => '1980112233',
                'nama' => 'Dosen',
                'email' => 'dosen@example.com',
                'password' => Hash::make('password'),
                'status' => 'Aktif',
                'foto_profile' => 'default.jpg',
            ],
            [
                'nama_lengkap' => 'Tendik Pro',
                'nomor_induk' => '1975123456',
                'nama' => 'Tendik',
                'email' => 'tendik@example.com',
                'password' => Hash::make('password'),
                'status' => 'Aktif',
                'foto_profile' => 'default.jpg',
            ],
            [
                'nama_lengkap' => 'Sarpras Admin',
                'nomor_induk' => '1989011223',
                'nama' => 'Sarpras',
                'email' => 'sarpras@example.com',
                'password' => Hash::make('password'),
                'status' => 'Aktif',
                'foto_profile' => 'default.jpg',
            ],
            [
                'nama_lengkap' => 'Teknisi Hebat',
                'nomor_induk' => '1995123456',
                'nama' => 'Teknisi',
                'email' => 'teknisi@example.com',
                'password' => Hash::make('password'),
                'status' => 'Aktif',
                'foto_profile' => 'default.jpg',
            ],
        ];

        foreach ($users as $user) {
            UserModel::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
