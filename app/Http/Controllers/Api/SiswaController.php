<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Http\Resources\SiswaResource;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'user']);

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->has('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }

        $siswa = $query->paginate($request->input('per_page', 15));

        return SiswaResource::collection($siswa);
    }

    public function store(StoreSiswaRequest $request)
    {
        $siswa = Siswa::create($request->validated());
        $siswa->load(['kelas', 'user']);

        return (new SiswaResource($siswa))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'user', 'nilai.mataPelajaran']);
        return new SiswaResource($siswa);
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $siswa->update($request->validated());
        $siswa->load(['kelas', 'user']);

        return new SiswaResource($siswa);
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return response()->json([
            'message' => 'Data siswa berhasil dihapus.',
        ], 200);
    }
}
