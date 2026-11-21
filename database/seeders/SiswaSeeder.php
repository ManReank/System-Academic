<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'siswa')->get();
        $kelasIds = Kelas::pluck('id_kelas')->toArray();

        foreach ($users as $index => $user) {
            Siswa::create([
                'user_id' => $user->id,
                'id_kelas' => $kelasIds[$index % count($kelasIds)],
                'nama' => $user->name,
                'jenis_kelamin' => $index % 2 === 0 ? 'L' : 'P',
                'tanggal_lahir' => '2007-0' . (($index % 9) + 1) . '-15',
                'alamat' => 'Jl. Siswa No. ' . ($index + 1) . ', Kemangkon',
            ]);
        }
    }
}
