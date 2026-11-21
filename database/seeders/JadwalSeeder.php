<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $kelasIds = Kelas::pluck('id_kelas')->toArray();
        $mapelIds = MataPelajaran::pluck('id_mapel')->toArray();
        $guruIds = Guru::pluck('id_guru')->toArray();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Bikin jadwal 2 mapel per hari per kelas
        $jamSlots = [
            ['07:00:00', '08:30:00'],
            ['08:30:00', '10:00:00'],
        ];

        foreach ($kelasIds as $idKelas) {
            foreach ($hari as $h) {
                foreach ($jamSlots as $slotIndex => $jam) {
                    // Rotasi mapel & guru biar variatif
                    $idMapel = $mapelIds[($idKelas + $slotIndex) % count($mapelIds)];
                    $idGuru = $guruIds[($idKelas + $slotIndex) % count($guruIds)];

                    Jadwal::create([
                        'id_kelas' => $idKelas,
                        'id_mapel' => $idMapel,
                        'id_guru' => $idGuru,
                        'hari' => $h,
                        'jam_mulai' => $jam[0],
                        'jam_selesai' => $jam[1],
                    ]);
                }
            }
        }
    }
}
