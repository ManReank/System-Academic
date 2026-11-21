<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_siswa' => ['required', 'exists:siswa,id_siswa'],
            'id_mapel' => ['required', 'exists:mata_pelajaran,id_mapel'],
            'id_guru' => ['required', 'exists:guru,id_guru'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
            'tahun_ajaran' => ['required', 'string', 'regex:/^\d{4}\/\d{4}$/'], // format 2024/2025
            'semester' => ['required', 'in:Ganjil,Genap'],
        ];
    }

    public function messages(): array
    {
        return [
            'tahun_ajaran.regex' => 'Format tahun ajaran harus YYYY/YYYY, contoh: 2024/2025.',
        ];
    }
}
