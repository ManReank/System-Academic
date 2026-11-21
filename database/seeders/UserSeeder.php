<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@smk-kemangkon.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 5 Guru
        $guru = [
    ['name' => 'Budi Santoso, S.Pd', 'username' => 'budi', 'email' => 'budi@smk.sch.id'],
    ['name' => 'Siti Aminah, S.Pd', 'username' => 'siti', 'email' => 'siti@smk.sch.id'],
    ['name' => 'Ahmad Fauzi, S.Kom', 'username' => 'ahmad', 'email' => 'ahmad@smk.sch.id'],
    ['name' => 'Dewi Lestari, S.Pd', 'username' => 'dewi', 'email' => 'dewi@smk.sch.id'],
    ['name' => 'Eko Prasetyo, S.Pd', 'username' => 'eko', 'email' => 'eko@smk.sch.id'],
    ['name' => 'Fitri Handayani, S.Pd', 'username' => 'fitri', 'email' => 'fitri@smk.sch.id'],
    ['name' => 'Gunawan Wibisono, S.Kom', 'username' => 'gunawan', 'email' => 'gunawan@smk.sch.id'],
    ['name' => 'Hesti Purwanti, S.Pd', 'username' => 'hesti', 'email' => 'hesti@smk.sch.id'],
        ];
        foreach ($guru as $g) {
            User::create([
                'name' => $g['name'],
                'username' => $g['username'],
                'email' => $g['email'],
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]);
        }

        // 20 Siswa
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => 'Siswa ' . $i,
                'username' => 'siswa' . $i,
                'email' => 'siswa' . $i . '@smk.sch.id',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);
        }
    }
}
