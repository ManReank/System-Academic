<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNilaiRequest;
use App\Http\Requests\UpdateNilaiRequest;
use App\Http\Resources\NilaiResource;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Bobot nilai: Tugas 30%, UTS 30%, UAS 40%
     */
    private function hitungNilaiAkhir(float $tugas, float $uts, float $uas): float
    {
        return round(($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4), 2);
    }

    public function index(Request $request)
    {
        $query = Nilai::with(['siswa', 'mataPelajaran', 'guru']);

        if ($request->has('id_siswa')) {
            $query->where('id_siswa', $request->id_siswa);
        }

        if ($request->has('id_mapel')) {
            $query->where('id_mapel', $request->id_mapel);
        }

        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        if ($request->has('id_kelas')) {
            $query->whereHas('siswa', fn ($q) => $q->where('id_kelas', $request->id_kelas));
        }

        if ($request->has('id_guru')) {
            $query->where('id_guru', $request->id_guru);
        }

        $nilai = $query->paginate($request->input('per_page', 15));

        return NilaiResource::collection($nilai);
    }

    public function store(StoreNilaiRequest $request)
    {
        $data = $request->validated();

        // Auto-hitung nilai_akhir
        $data['nilai_akhir'] = $this->hitungNilaiAkhir(
            (float) $data['nilai_tugas'],
            (float) $data['nilai_uts'],
            (float) $data['nilai_uas']
        );

        $nilai = Nilai::create($data);
        $nilai->load(['siswa', 'mataPelajaran', 'guru']);

        return (new NilaiResource($nilai))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Nilai $nilai)
    {
        $nilai->load(['siswa', 'mataPelajaran', 'guru']);
        return new NilaiResource($nilai);
    }

    public function update(UpdateNilaiRequest $request, Nilai $nilai)
    {
        $data = $request->validated();

        // Kalau salah satu komponen nilai di-update, recalculate nilai_akhir
        if (isset($data['nilai_tugas']) || isset($data['nilai_uts']) || isset($data['nilai_uas'])) {
            $data['nilai_akhir'] = $this->hitungNilaiAkhir(
                (float) ($data['nilai_tugas'] ?? $nilai->nilai_tugas),
                (float) ($data['nilai_uts'] ?? $nilai->nilai_uts),
                (float) ($data['nilai_uas'] ?? $nilai->nilai_uas)
            );
        }

        $nilai->update($data);
        $nilai->load(['siswa', 'mataPelajaran', 'guru']);

        return new NilaiResource($nilai);
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return response()->json([
            'message' => 'Data nilai berhasil dihapus.',
        ], 200);
    }


    public function nilaiSaya(Request $request)
    {
        $user = $request->user();

        if (!$user->isSiswa()) {
            return response()->json(['message' => 'Endpoint ini hanya untuk siswa.'], 403);
        }

        $siswa = $user->siswa;
        if (!$siswa) {
            return response()->json(['message' => 'Profil siswa belum dibuat.'], 404);
        }

        $query = Nilai::with(['mataPelajaran', 'guru'])
            ->where('id_siswa', $siswa->id_siswa);

        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->has('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        return NilaiResource::collection($query->get());
    }


    public function raporSaya(Request $request)
    {
        $user = $request->user();

        if (!$user->isSiswa()) {
            return response()->json(['message' => 'Endpoint ini hanya untuk siswa.'], 403);
        }

        $siswa = $user->siswa;
        if (!$siswa) {
            return response()->json(['message' => 'Profil siswa belum dibuat.'], 404);
        }

        $nilai = Nilai::with(['mataPelajaran', 'guru'])
            ->where('id_siswa', $siswa->id_siswa)
            ->get();

        $grouped = $nilai->groupBy(fn ($n) => $n->tahun_ajaran . ' - ' . $n->semester)
            ->map(function ($items, $key) {
                return [
                    'periode' => $key,
                    'nilai' => $items->map(fn ($n) => [
                        'mata_pelajaran' => $n->mataPelajaran->nama_mapel,
                        'kode_mapel' => $n->mataPelajaran->kode_mapel,
                        'guru' => $n->guru->nama,
                        'nilai_tugas' => (float) $n->nilai_tugas,
                        'nilai_uts' => (float) $n->nilai_uts,
                        'nilai_uas' => (float) $n->nilai_uas,
                        'nilai_akhir' => (float) $n->nilai_akhir,
                    ]),
                    'rata_rata' => round($items->avg('nilai_akhir'), 2),
                ];
            })->values();

        return response()->json([
            'siswa' => [
                'nama' => $siswa->nama,
                'kelas' => $siswa->kelas?->nama_kelas,
            ],
            'rapor' => $grouped,
        ]);
    }
}
