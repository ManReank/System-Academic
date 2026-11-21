<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $idKelas = $this->route('kelas')?->id_kelas ?? $this->route('kelas');

        return [
            'nama_kelas' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('kelas', 'nama_kelas')->ignore($idKelas, 'id_kelas'),
            ],
            'tingkat' => ['sometimes', 'in:X,XI,XII'],
            'id_wali_kelas' => ['sometimes', 'nullable', 'exists:guru,id_guru'],
        ];
    }
}
