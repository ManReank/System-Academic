<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\Http\Resources\MataPelajaranResource;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::withCount(['jadwal', 'nilai']);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_mapel', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_mapel', 'like', '%' . $request->search . '%');
            });
        }

        $mapel = $query->paginate($request->input('per_page', 15));

        return MataPelajaranResource::collection($mapel);
    }

    public function store(StoreMataPelajaranRequest $request)
    {
        $mapel = MataPelajaran::create($request->validated());

        return (new MataPelajaranResource($mapel))
            ->response()
            ->setStatusCode(201);
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->loadCount(['jadwal', 'nilai']);
        return new MataPelajaranResource($mataPelajaran);
    }

    public function update(UpdateMataPelajaranRequest $request, MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->update($request->validated());

        return new MataPelajaranResource($mataPelajaran);
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return response()->json([
            'message' => 'Data mata pelajaran berhasil dihapus.',
        ], 200);
    }
}
