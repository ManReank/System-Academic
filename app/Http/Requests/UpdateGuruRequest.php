<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil id_guru dari route untuk ignore unique-nya sendiri
        $idGuru = $this->route('guru')?->id_guru ?? $this->route('guru');

        return [
            'user_id' => [
                'sometimes',
                'exists:users,id',
                Rule::unique('guru', 'user_id')->ignore($idGuru, 'id_guru'),
            ],
            'nip' => [
                'sometimes',
                'string',
                'max:30',
                Rule::unique('guru', 'nip')->ignore($idGuru, 'id_guru'),
            ],
            'nama' => ['sometimes', 'string', 'max:100'],
            'jenis_kelamin' => ['sometimes', 'in:L,P'],
            'no_telp' => ['sometimes', 'nullable', 'string', 'max:15'],
            'alamat' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
