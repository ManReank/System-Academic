<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
{
    $users = User::where('role', 'guru')->get();

    foreach ($users as $index => $user) {
        Guru::create([
            'user_id' => $user->id,
            'nip' => '198001' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
            'nama' => $user->name,
            'jenis_kelamin' => $index % 2 === 0 ? 'L' : 'P',
            'no_telp' => '0812345678' . $index,
            'alamat' => 'Jl. Pendidikan No. ' . ($index + 1) . ', Kemangkon',
        ]);
    }

}

}
