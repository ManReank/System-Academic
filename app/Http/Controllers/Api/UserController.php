<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('role')->orderBy('name')
                       ->paginate($request->input('per_page', 15));

        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user->fresh());
    }

    public function destroy(User $user, Request $request)
    {
        if ($user->id === $request->user()->id) {
            return response()->json([
                'message' => 'Tidak bisa menghapus akun sendiri.',
            ], 422);
        }

        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus.']);
    }

    /**
     * Dashboard Statistics
     */
    public function dashboardStats()
    {
        return response()->json([
            'totals' => [
                'siswa' => Siswa::count(),
                'guru' => Guru::count(),
                'kelas' => Kelas::count(),
                'mata_pelajaran' => MataPelajaran::count(),
                'jadwal' => Jadwal::count(),
                'nilai' => Nilai::count(),
            ],
            'siswa_per_tingkat' => Kelas::selectRaw('tingkat, COUNT(*) as jumlah_kelas')
                ->groupBy('tingkat')
                ->pluck('jumlah_kelas', 'tingkat'),
            'guru_per_gender' => Guru::selectRaw('jenis_kelamin, COUNT(*) as jumlah')
                ->groupBy('jenis_kelamin')
                ->pluck('jumlah', 'jenis_kelamin'),
            'nilai_rata_rata' => [
                'tugas' => round(Nilai::avg('nilai_tugas'), 2),
                'uts' => round(Nilai::avg('nilai_uts'), 2),
                'uas' => round(Nilai::avg('nilai_uas'), 2),
                'akhir' => round(Nilai::avg('nilai_akhir'), 2),
            ],
        ]);
    }
}
