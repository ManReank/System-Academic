<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Http\Resources\GuruResource;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with(['user', 'kelasWali']);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $guru = $query->paginate($request->input('per_page', 15));

        return GuruResource::collection($guru);
    }

    public function store(StoreGuruRequest $request)
    {
        $guru = Guru::create($request->validated());
        $guru->load(['user', 'kelasWali']);

        return (new GuruResource($guru))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Guru $guru)
    {
        $guru->load(['user', 'kelasWali', 'jadwal.mataPelajaran', 'jadwal.kelas']);
        return new GuruResource($guru);
    }

    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        $guru->update($request->validated());
        $guru->load(['user', 'kelasWali']);

        return new GuruResource($guru);
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return response()->json([
            'message' => 'Data guru berhasil dihapus.',
        ], 200);
    }
}
