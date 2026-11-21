<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $siswaIds = Siswa::pluck('id_siswa')->toArray();
        $mapelIds = MataPelajaran::pluck('id_mapel')->toArray();
        $guruIds = Guru::pluck('id_guru')->toArray();

        foreach ($siswaIds as $idSiswa) {
            foreach ($mapelIds as $idMapel) {
                $tugas = rand(65, 95);
                $uts = rand(65, 95);
                $uas = rand(65, 95);
                $akhir = round(($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4), 2);

                Nilai::create([
                    'id_siswa' => $idSiswa,
                    'id_mapel' => $idMapel,
                    'id_guru' => $guruIds[array_rand($guruIds)],
                    'nilai_tugas' => $tugas,
                    'nilai_uts' => $uts,
                    'nilai_uas' => $uas,
                    'nilai_akhir' => $akhir,
                    'tahun_ajaran' => '2024/2025',
                    'semester' => 'Ganjil',
                ]);
            }
        }
    }
}
