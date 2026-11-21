<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Jadwal;

class StoreJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kelas' => ['required', 'exists:kelas,id_kelas'],
            'id_mapel' => ['required', 'exists:mata_pelajaran,id_mapel'],
            'id_guru' => ['required', 'exists:guru,id_guru'],
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'jam_mulai' => ['required', 'date_format:H:i:s,H:i'],
            'jam_selesai' => ['required', 'date_format:H:i:s,H:i', 'after:jam_mulai'],
        ];
    }

    /**
     * Validasi tambahan: cek bentrok jadwal guru & kelas
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return; // skip kalau validasi dasar gagal
            }

            $hari = $this->input('hari');
            $jamMulai = $this->input('jam_mulai');

            // Cek bentrok GURU: guru yang sama di hari & jam sama
            $bentrokGuru = Jadwal::where('id_guru', $this->input('id_guru'))
                ->where('hari', $hari)
                ->where('jam_mulai', $jamMulai)
                ->exists();

            if ($bentrokGuru) {
                $validator->errors()->add(
                    'id_guru',
                    'Guru ini sudah mengajar di hari ' . $hari . ' jam ' . $jamMulai . ' di kelas lain.'
                );
            }

            // Cek bentrok KELAS: kelas yang sama di hari & jam sama
            $bentrokKelas = Jadwal::where('id_kelas', $this->input('id_kelas'))
                ->where('hari', $hari)
                ->where('jam_mulai', $jamMulai)
                ->exists();

            if ($bentrokKelas) {
                $validator->errors()->add(
                    'id_kelas',
                    'Kelas ini sudah punya jadwal di hari ' . $hari . ' jam ' . $jamMulai . '.'
                );
            }
        });
    }
}
