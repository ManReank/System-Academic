<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Jadwal;

class UpdateJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kelas' => ['sometimes', 'exists:kelas,id_kelas'],
            'id_mapel' => ['sometimes', 'exists:mata_pelajaran,id_mapel'],
            'id_guru' => ['sometimes', 'exists:guru,id_guru'],
            'hari' => ['sometimes', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'jam_mulai' => ['sometimes', 'date_format:H:i:s,H:i'],
            'jam_selesai' => ['sometimes', 'date_format:H:i:s,H:i', 'after:jam_mulai'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $jadwal = $this->route('jadwal');
            $idJadwal = is_object($jadwal) ? $jadwal->id_jadwal : $jadwal;

            // Ambil value final (kalau nggak di-update, pake yang lama)
            $current = Jadwal::find($idJadwal);
            if (!$current) {
                return;
            }

            $hari = $this->input('hari', $current->hari);
            $jamMulai = $this->input('jam_mulai', $current->jam_mulai);
            $idGuru = $this->input('id_guru', $current->id_guru);
            $idKelas = $this->input('id_kelas', $current->id_kelas);

            // Cek bentrok guru (kecuali record ini sendiri)
            $bentrokGuru = Jadwal::where('id_guru', $idGuru)
                ->where('hari', $hari)
                ->where('jam_mulai', $jamMulai)
                ->where('id_jadwal', '!=', $idJadwal)
                ->exists();

            if ($bentrokGuru) {
                $validator->errors()->add('id_guru', 'Guru sudah mengajar di hari & jam tersebut.');
            }

            // Cek bentrok kelas
            $bentrokKelas = Jadwal::where('id_kelas', $idKelas)
                ->where('hari', $hari)
                ->where('jam_mulai', $jamMulai)
                ->where('id_jadwal', '!=', $idJadwal)
                ->exists();

            if ($bentrokKelas) {
                $validator->errors()->add('id_kelas', 'Kelas sudah punya jadwal di hari & jam tersebut.');
            }
        });
    }
}
