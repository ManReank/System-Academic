<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mapel';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
    ];

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_mapel');
    }

    // Relasi ke Nilai
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_mapel');
    }
}
