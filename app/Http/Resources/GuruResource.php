<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_guru' => $this->id_guru,
            'nip' => $this->nip,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'email' => $this->user->email,
            ]),
            'kelas_wali' => $this->whenLoaded('kelasWali', fn () => $this->kelasWali->map(fn ($k) => [
                'id_kelas' => $k->id_kelas,
                'nama_kelas' => $k->nama_kelas,
                'tingkat' => $k->tingkat,
            ])),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
