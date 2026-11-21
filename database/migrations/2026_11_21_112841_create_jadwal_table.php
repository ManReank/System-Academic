<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_kelas')->constrained('kelas', 'id_kelas')->onDelete('cascade');
            $table->foreignId('id_mapel')->constrained('mata_pelajaran', 'id_mapel')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('guru', 'id_guru')->onDelete('cascade');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            // Guru nggak bisa ngajar di 2 kelas pada hari & jam yang sama
            $table->unique(['id_guru', 'hari', 'jam_mulai'], 'jadwal_guru_unique');
            // 1 kelas nggak bisa ada 2 mapel di jam yang sama
            $table->unique(['id_kelas', 'hari', 'jam_mulai'], 'jadwal_kelas_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
