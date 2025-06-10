<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $itemNamesGeneral = [
            'AC',
            'Kursi',
            'Meja',
            'Proyektor',
            'Access Point',
            'Stop Kontak',
            'Ubin Lantai',
            'Pintu',
            'Jendela',
            'Lampu',
            'Papan Tulis',
            'Lemari',
            'Korden',
            'Kabel',
            'Plafon',
            'Tembok',
            'Jaringan',
        ];

        $now = Carbon::now();
        $data = [];

        // Ambil semua ruang dari tabel m_ruang
        $ruangs = DB::table('m_ruang')->get();

        foreach ($ruangs as $ruang) {
            // Tambahkan item umum
            foreach ($itemNamesGeneral as $itemName) {
                $data[] = [
                    'ruang_id' => $ruang->ruang_id,
                    'fasum_id' => null,
                    'nama' => $itemName,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Tambahkan Colokan LAN jika ruang adalah Lab Komputasi Jaringan 1 atau 2
            if (in_array($ruang->nama, [
                'Laboratorium Komputasi Jaringan 1',
                'Laboratorium Komputasi Jaringan 2',
            ])) {
                $data[] = [
                    'ruang_id' => $ruang->ruang_id,
                    'fasum_id' => null,
                    'nama' => 'Colokan LAN',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Masukkan ke tabel m_item
        DB::table('m_item')->insert($data);
    }
}
