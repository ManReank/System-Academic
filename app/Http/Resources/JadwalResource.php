<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_jadwal' => $this->id_jadwal,
            'hari' => $this->hari,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'kelas' => $this->whenLoaded('kelas', fn () => [
                'id_kelas' => $this->kelas->id_kelas,
                'nama_kelas' => $this->kelas->nama_kelas,
                'tingkat' => $this->kelas->tingkat,
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
