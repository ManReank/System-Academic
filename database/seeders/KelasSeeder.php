<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $guruIds = Guru::pluck('id_guru')->toArray();
        $daftarKelas = [
            ['nama_kelas' => 'X RPL 1', 'tingkat' => 'X'],
            ['nama_kelas' => 'X RPL 2', 'tingkat' => 'X'],
            ['nama_kelas' => 'XI RPL 1', 'tingkat' => 'XI'],
            ['nama_kelas' => 'XI RPL 2', 'tingkat' => 'XI'],
            ['nama_kelas' => 'XII RPL 1', 'tingkat' => 'XII'],
            ['nama_kelas' => 'XII RPL 2', 'tingkat' => 'XII'],
        ];

        foreach ($daftarKelas as $index => $k) {
            Kelas::create([
                'nama_kelas' => $k['nama_kelas'],
                'tingkat' => $k['tingkat'],
                'id_wali_kelas' => $guruIds[$index % count($guruIds)],
            ]);
        }
    }
}
