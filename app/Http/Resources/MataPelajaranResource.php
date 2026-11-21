<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MataPelajaranResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_mapel' => $this->id_mapel,
            'kode_mapel' => $this->kode_mapel,
            'nama_mapel' => $this->nama_mapel,
            'jadwal_count' => $this->whenCounted('jadwal'),
            'nilai_count' => $this->whenCounted('nilai'),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
