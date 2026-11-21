<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id', 'unique:guru,user_id'],
            'nip' => ['required', 'string', 'max:30', 'unique:guru,nip'],
            'nama' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'no_telp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string'],
        ];
    }
}
