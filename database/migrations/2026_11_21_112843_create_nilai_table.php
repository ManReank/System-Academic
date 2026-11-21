<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_mapel')->constrained('mata_pelajaran', 'id_mapel')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('guru', 'id_guru')->onDelete('cascade');
            $table->decimal('nilai_tugas', 5, 2)->default(0);
            $table->decimal('nilai_uts', 5, 2)->default(0);
            $table->decimal('nilai_uas', 5, 2)->default(0);
            $table->decimal('nilai_akhir', 5, 2)->default(0);
            $table->string('tahun_ajaran', 10);
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->timestamps();

            // 1 siswa cuma boleh punya 1 nilai per mapel per semester
            $table->unique(
                ['id_siswa', 'id_mapel', 'tahun_ajaran', 'semester'],
                'nilai_siswa_mapel_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
