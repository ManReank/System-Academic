<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJadwalRequest;
use App\Http\Requests\UpdateJadwalRequest;
use App\Http\Resources\JadwalResource;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kelas', 'mataPelajaran', 'guru']);

        // Filter by kelas
        if ($request->has('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }

        // Filter by guru
        if ($request->has('id_guru')) {
            $query->where('id_guru', $request->id_guru);
        }

        // Filter by hari
        if ($request->has('hari')) {
            $query->where('hari', $request->hari);
        }

        // Urutin berdasarkan hari & jam
        $query->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
              ->orderBy('jam_mulai');

        $jadwal = $query->paginate($request->input('per_page', 15));

        return JadwalResource::collection($jadwal);
    }

    public function store(StoreJadwalRequest $request)
    {
        $jadwal = Jadwal::create($request->validated());
        $jadwal->load(['kelas', 'mataPelajaran', 'guru']);

        return (new JadwalResource($jadwal))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load(['kelas', 'mataPelajaran', 'guru']);
        return new JadwalResource($jadwal);
    }

    public function update(UpdateJadwalRequest $request, Jadwal $jadwal)
    {
        $jadwal->update($request->validated());
        $jadwal->load(['kelas', 'mataPelajaran', 'guru']);

        return new JadwalResource($jadwal);
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return response()->json([
            'message' => 'Data jadwal berhasil dihapus.',
        ], 200);
    }
    public function jadwalSaya(Request $request)
    {
        $user = $request->user();

        if ($user->isGuru()) {
            $guru = $user->guru;
            if (!$guru) {
                return response()->json(['message' => 'Profil guru belum dibuat.'], 404);
            }
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran'])
            ->where('id_guru', $guru->id_guru)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();
        } elseif ($user->isSiswa()) {
            $siswa = $user->siswa;
            if (!$siswa || !$siswa->id_kelas) {
            return response()->json(['message' => 'Kelas siswa belum ditentukan.'], 404);
            }
        $jadwal = Jadwal::with(['mataPelajaran', 'guru'])
            ->where('id_kelas', $siswa->id_kelas)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();
        } else {
            return response()->json(['message' => 'Endpoint hanya untuk guru/siswa.'], 403);
        }

        return JadwalResource::collection($jadwal);
    }

}
