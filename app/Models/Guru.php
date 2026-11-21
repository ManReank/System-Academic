<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'no_telp',
        'alamat',
    ];

    // Relasi ke User (1 guru = 1 user)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Kelas sebagai wali kelas (1 guru bisa jadi wali di banyak kelas)
    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'id_wali_kelas');
    }

    // Relasi ke Jadwal (1 guru bisa ngajar banyak jadwal)
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_guru');
    }

    // Relasi ke Nilai (1 guru bisa input banyak nilai)
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_guru');
    }
}
