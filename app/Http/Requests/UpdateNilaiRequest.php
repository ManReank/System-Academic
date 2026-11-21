<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_siswa' => ['sometimes', 'exists:siswa,id_siswa'],
            'id_mapel' => ['sometimes', 'exists:mata_pelajaran,id_mapel'],
            'id_guru' => ['sometimes', 'exists:guru,id_guru'],
            'nilai_tugas' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'tahun_ajaran' => ['sometimes', 'string', 'regex:/^\d{4}\/\d{4}$/'],
            'semester' => ['sometimes', 'in:Ganjil,Genap'],
        ];
    }
}
