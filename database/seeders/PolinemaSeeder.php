<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolinemaSeeder extends Seeder
{
    public function run()
    {
        // Reset dan hapus semua data karena seed berulang-ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('m_fasum')->truncate();
        DB::table('m_ruang')->truncate();
        DB::table('m_gedung')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Seeder untuk tabel m_gedung
        $gedungData = [
            ['kode' => 'AA', 'nama' => 'Kantor Pusat'],
            ['kode' => 'AB', 'nama' => 'Jurusan Administrasi Niaga'],
            ['kode' => 'AC', 'nama' => 'Lab. Jurusan Akuntansi dan Administrasi Niaga'],
            ['kode' => 'AD', 'nama' => 'Jurusan Akuntansi'],
            ['kode' => 'AE', 'nama' => 'Gedung Akuntansi dan Administrasi Niaga'],
            ['kode' => 'AF', 'nama' => 'Gedung Program 1 Tahun'],
            ['kode' => 'AG', 'nama' => 'Jurusan Teknik Elektronika dan Teknik Listrik'],
            ['kode' => 'AH', 'nama' => 'Bengkel dan Lab. Teknik Telekomunikasi'],
            ['kode' => 'AI', 'nama' => 'Bengkel dan Lab. Teknik Elektronika'],
            ['kode' => 'AJ', 'nama' => 'Bengkel dan Lab. Teknik Listrik'],
            ['kode' => 'AK', 'nama' => 'Lab. Broadcasting'],
            ['kode' => 'AL', 'nama' => 'Lab. Broadcasting'],
            ['kode' => 'AM', 'nama' => 'Aula Pertamina'],
            ['kode' => 'AN', 'nama' => 'Genset dan Gardu Distribusi'],
            ['kode' => 'AO', 'nama' => 'Gedung Jurusan Kimia'],
            ['kode' => 'AP', 'nama' => 'Lab. Biodiesel'],
            ['kode' => 'AQ', 'nama' => 'Lab. Jurusan Teknik Kimia'],
            ['kode' => 'AR', 'nama' => 'Poliklinik'],
            ['kode' => 'AS', 'nama' => 'Grasi dan UKM'],
            ['kode' => 'AT', 'nama' => 'UPT Percetakan'],
            ['kode' => 'AU', 'nama' => 'Gedung Arsip'],
            ['kode' => 'AV', 'nama' => 'Graha Theater'],
            ['kode' => 'AW', 'nama' => 'Pusat Informasi'],
            ['kode' => 'AX', 'nama' => 'Parkiran dan Kantin'],
            ['kode' => 'GST', 'nama' => 'Gedung Jurusan Sipil dan Teknologi Informasi'],
            ['kode' => 'GM', 'nama' => 'Gedung Jurusan Mesin'],
            ['kode' => 'GRAPOL', 'nama' => 'Graha Polinema'],

        ];

        // Array untuk menyimpan mapping kode gedung dengan ID yang dihasilkan
        $gedungIdMap = [];

        foreach ($gedungData as $gedung) {
            $gedungId = DB::table('m_gedung')->insertGetId([
                'kode' => $gedung['kode'],
                'nama' => $gedung['nama'],
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()')
            ]);
            
            // Simpan mapping kode gedung dengan ID
            $gedungIdMap[$gedung['kode']] = $gedungId;
        }

        // Dapatkan ID gedung GST untuk ruang-ruang TI
        $gedungGstId = $gedungIdMap['GST'];

        // Seeder untuk tabel m_ruang
        $ruangData = [
            // Lantai 5 Lokasi 5B
            ['kode' => 'RT1L5B', 'nama' => 'Ruang Teori 1', 'gedung_id' => $gedungGstId, 'lantai' => 5],
            ['kode' => 'RT2L5B', 'nama' => 'Ruang Teori 2', 'gedung_id' => $gedungGstId, 'lantai' => 5],
            ['kode' => 'RT3L5B', 'nama' => 'Ruang Teori 3', 'gedung_id' => $gedungGstId, 'lantai' => 5],
            ['kode' => 'RT4L5B', 'nama' => 'Ruang Teori 4', 'gedung_id' => $gedungGstId, 'lantai' => 5],
            ['kode' => 'RT5L5B', 'nama' => 'Ruang Teori 5', 'gedung_id' => $gedungGstId, 'lantai' => 5],
            ['kode' => 'RT6L5B', 'nama' => 'Ruang Teori 6', 'gedung_id' => $gedungGstId, 'lantai' => 5],
            ['kode' => 'RT7L5B', 'nama' => 'Ruang Teori 7', 'gedung_id' => $gedungGstId, 'lantai' => 5],
            ['kode' => 'LPY1L5B', 'nama' => 'Laboratorium Proyek 1', 'gedung_id' => $gedungGstId, 'lantai' => 5],

            // Lantai 6 Lokasi 6B
            ['kode' => 'RD1L6B', 'nama' => 'Ruang Dosen 1', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RD2L6B', 'nama' => 'Ruang Dosen 2', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RD3L6B', 'nama' => 'Ruang Dosen 3', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RD4L6B', 'nama' => 'Ruang Dosen 4', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RD5L6B', 'nama' => 'Ruang Dosen 5', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RD6L6B', 'nama' => 'Ruang Dosen 6', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RJTIL6B', 'nama' => 'Ruang Jurusan Teknologi Informasi', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RKPL6B', 'nama' => 'Ruang Ketua Program Studi', 'gedung_id' => $gedungGstId, 'lantai' => 6],

            // Lantai 6 Lokasi 6T
            ['kode' => 'RBLL6T', 'nama' => 'Ruang Baca', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'LSI1L6T', 'nama' => 'Laboratorium Sistem Informasi 1', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'LSI2L6T', 'nama' => 'Laboratorium Sistem Informasi 2', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'LSI3L6T', 'nama' => 'Laboratorium Sistem Informasi 3', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RAL6T', 'nama' => 'Ruang Arsip', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'LPY2L6T', 'nama' => 'Laboratorium Proyek 2', 'gedung_id' => $gedungGstId, 'lantai' => 6],
            ['kode' => 'RWEL6T', 'nama' => 'Ruang Workshop Elektro', 'gedung_id' => $gedungGstId, 'lantai' => 6],

            // Lantai 7 Lokasi 7B
            ['kode' => 'LPR1L7B', 'nama' => 'Laboratorium Pemrograman 1', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LPR2L7B', 'nama' => 'Laboratorium Pemrograman 2', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LPR3L7B', 'nama' => 'Laboratorium Pemrograman 3', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LPR4L7B', 'nama' => 'Laboratorium Pemrograman 4', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LPR5L7B', 'nama' => 'Laboratorium Pemrograman 5', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LPR6L7B', 'nama' => 'Laboratorium Pemrograman 6', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LPR7L7B', 'nama' => 'Laboratorium Pemrograman 7', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LKJ1L7B', 'nama' => 'Laboratorium Komputasi Jaringan 1', 'gedung_id' => $gedungGstId, 'lantai' => 7],

            // Lantai 7 Lokasi 7T
            ['kode' => 'LPR8L7T', 'nama' => 'Laboratorium Pemrograman 8', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LIG1L7T', 'nama' => 'Laboratorium Internet of Things 1', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LIG2L7T', 'nama' => 'Laboratorium Internet of Things 2', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LKJ2L7T', 'nama' => 'Laboratorium Komputasi Jaringan 2', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LKJ3L7T', 'nama' => 'Laboratorium Komputasi Jaringan 3', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LERPL7T', 'nama' => 'Laboratorium Enterprise Resource Planning', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LPY4L7T', 'nama' => 'Laboratorium Proyek 4', 'gedung_id' => $gedungGstId, 'lantai' => 7],
            ['kode' => 'LAI1L7T', 'nama' => 'Laboratorium Artificial Intelligence 1', 'gedung_id' => $gedungGstId, 'lantai' => 7],

            // Lantai 8 Lokasi 8B
            ['kode' => 'RT8L8B', 'nama' => 'Ruang Teori 8', 'gedung_id' => $gedungGstId, 'lantai' => 8],
            ['kode' => 'RT9L8B', 'nama' => 'Ruang Teori 9', 'gedung_id' => $gedungGstId, 'lantai' => 8],
            ['kode' => 'RT10L8B', 'nama' => 'Ruang Teori 10', 'gedung_id' => $gedungGstId, 'lantai' => 8],
            ['kode' => 'RT11L8B', 'nama' => 'Ruang Teori 11', 'gedung_id' => $gedungGstId, 'lantai' => 8],
            ['kode' => 'RT12L8B', 'nama' => 'Ruang Teori 12', 'gedung_id' => $gedungGstId, 'lantai' => 8],
            ['kode' => 'LAI2L8B', 'nama' => 'Laboratorium Artificial Intelligence 2', 'gedung_id' => $gedungGstId, 'lantai' => 8],

            // Lantai 8 Lokasi 8T
            ['kode' => 'RT13L8T', 'nama' => 'Ruang Teori 13', 'gedung_id' => $gedungGstId, 'lantai' => 8],
            ['kode' => 'RT14L8T', 'nama' => 'Ruang Teori 14', 'gedung_id' => $gedungGstId, 'lantai' => 8]
        ];

        foreach ($ruangData as $ruang) {
            DB::table('m_ruang')->insert([
                'kode' => $ruang['kode'],
                'nama' => $ruang['nama'],
                'gedung_id' => $ruang['gedung_id'],
                'lantai' => $ruang['lantai'],
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()')
            ]);
        }

        // Seeder untuk tabel m_fasum (Fasilitas Umum)
        $fasumData = [
            // Fasilitas di Graha Polinema
            ['nama' => 'Lapangan Basket'],
            ['nama' => 'Perpustakaan'],
            ['nama' => 'Gazebo'],
            ['nama' => 'Graha Teater'],

            // Fasilitas di Kampus Bagian Depan
            ['nama' => 'Masjid An-Nur Polinema'],
            ['nama' => 'Lapangan Futsal'],

            // Fasilitas di Kampus Bagian Tengah
            ['nama' => 'Poliklinik'],
            ['nama' => 'Aula Pertamina'],

            // Auditorium
            ['nama' => 'Auditorium Teknik Sipil'],
            ['nama' => 'Auditorium Pascasarjana']
        ];

        foreach ($fasumData as $fasum) {
            DB::table('m_fasum')->insert([
                'nama' => $fasum['nama'],
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()')
            ]);
        }
    }
}