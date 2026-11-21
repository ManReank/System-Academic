<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_kelas' => $this->id_kelas,
            'nama_kelas' => $this->nama_kelas,
            'tingkat' => $this->tingkat,
            'wali_kelas' => $this->whenLoaded('waliKelas', fn () => $this->waliKelas ? [
                'id_guru' => $this->waliKelas->id_guru,
                'nip' => $this->waliKelas->nip,
                'nama' => $this->waliKelas->nama,
            ] : null),
            'siswa_count' => $this->whenCounted('siswa'),
            'jadwal_count' => $this->whenCounted('jadwal'),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
