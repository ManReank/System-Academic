<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMataPelajaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $idMapel = $this->route('mata_pelajaran')?->id_mapel ?? $this->route('mata_pelajaran');

        return [
            'kode_mapel' => [
                'sometimes',
                'string',
                'max:10',
                Rule::unique('mata_pelajaran', 'kode_mapel')->ignore($idMapel, 'id_mapel'),
            ],
            'nama_mapel' => ['sometimes', 'string', 'max:100'],
        ];
    }
}
