<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NilaiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_nilai' => $this->id_nilai,
            'nilai_tugas' => (float) $this->nilai_tugas,
            'nilai_uts' => (float) $this->nilai_uts,
            'nilai_uas' => (float) $this->nilai_uas,
            'nilai_akhir' => (float) $this->nilai_akhir,
            'tahun_ajaran' => $this->tahun_ajaran,
            'semester' => $this->semester,
            'siswa' => $this->whenLoaded('siswa', fn () => [
                'id_siswa' => $this->siswa->id_siswa,
                'nama' => $this->siswa->nama,
            ]),
            'mata_pelajaran' => $this->whenLoaded('mataPelajaran', fn () => [
                'id_mapel' => $this->mataPelajaran->id_mapel,
                'kode_mapel' => $this->mataPelajaran->kode_mapel,
                'nama_mapel' => $this->mataPelajaran->nama_mapel,
            ]),
            'guru' => $this->whenLoaded('guru', fn () => [
                'id_guru' => $this->guru->id_guru,
                'nip' => $this->guru->nip,
                'nama' => $this->guru->nama,
            ]),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
