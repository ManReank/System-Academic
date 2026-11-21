<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_siswa',
        'id_mapel',
        'id_guru',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'tahun_ajaran',
        'semester',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    // Relasi ke Mata Pelajaran
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mapel');
    }

    // Relasi ke Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}
