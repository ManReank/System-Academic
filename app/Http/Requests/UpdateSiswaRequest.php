<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'exists:users,id'],
            'id_kelas' => ['sometimes', 'nullable', 'exists:kelas,id_kelas'],
            'nama' => ['sometimes', 'string', 'max:100'],
            'jenis_kelamin' => ['sometimes', 'in:L,P'],
            'tanggal_lahir' => ['sometimes', 'nullable', 'date'],
            'alamat' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
