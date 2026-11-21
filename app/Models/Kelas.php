<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'id_wali_kelas',
    ];

    // Relasi ke Guru (wali kelas)
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'id_wali_kelas');
    }

    // Relasi ke Siswa (1 kelas punya banyak siswa)
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }

    // Relasi ke Jadwal (1 kelas punya banyak jadwal)
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_kelas');
    }
}
