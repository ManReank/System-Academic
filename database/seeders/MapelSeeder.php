<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            ['kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika'],
            ['kode_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia'],
            ['kode_mapel' => 'BIG', 'nama_mapel' => 'Bahasa Inggris'],
            ['kode_mapel' => 'IPA', 'nama_mapel' => 'Ilmu Pengetahuan Alam'],
            ['kode_mapel' => 'IPS', 'nama_mapel' => 'Ilmu Pengetahuan Sosial'],
            ['kode_mapel' => 'PBO', 'nama_mapel' => 'Pemrograman Berorientasi Objek'],
            ['kode_mapel' => 'BD', 'nama_mapel' => 'Basis Data'],
            ['kode_mapel' => 'PW', 'nama_mapel' => 'Pemrograman Web'],
        ];

        foreach ($mapel as $m) {
            MataPelajaran::create($m);
        }
    }
}
