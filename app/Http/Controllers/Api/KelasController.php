<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Http\Resources\KelasResource;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with('waliKelas')->withCount(['siswa', 'jadwal']);

        if ($request->has('search')) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }

        if ($request->has('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $kelas = $query->paginate($request->input('per_page', 15));

        return KelasResource::collection($kelas);
    }

    public function store(StoreKelasRequest $request)
    {
        $kelas = Kelas::create($request->validated());
        $kelas->load('waliKelas');

        return (new KelasResource($kelas))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Kelas $kelas)
    {
        $kelas->load(['waliKelas', 'siswa.user', 'jadwal.mataPelajaran', 'jadwal.guru'])
              ->loadCount(['siswa', 'jadwal']);

        return new KelasResource($kelas);
    }

    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        $kelas->update($request->validated());
        $kelas->load('waliKelas');

        return new KelasResource($kelas);
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return response()->json([
            'message' => 'Data kelas berhasil dihapus.',
        ], 200);
    }
}
