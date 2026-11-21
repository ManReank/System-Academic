<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'siswa' => Siswa::count(),
            'guru' => Guru::count(),
            'kelas' => Kelas::count(),
            'mapel' => MataPelajaran::count(),
            'jadwal' => Jadwal::count(),
            'nilai' => Nilai::count(),
        ];
        $nilaiRata = round(Nilai::avg('nilai_akhir') ?? 0, 2);

        return view('dashboard.admin', compact('stats', 'nilaiRata'));
    }

    public function guru(Request $request)
    {
        $guru = $request->user()->guru;
        $stats = [
            'jadwal' => $guru ? Jadwal::where('id_guru', $guru->id_guru)->count() : 0,
            'kelas' => $guru ? Jadwal::where('id_guru', $guru->id_guru)->distinct()->count('id_kelas') : 0,
            'nilai' => $guru ? Nilai::where('id_guru', $guru->id_guru)->count() : 0,
        ];
        return view('dashboard.guru', compact('stats'));
    }

    public function siswa(Request $request)
    {
        $siswa = $request->user()->siswa;
        $rapor = collect();

        if ($siswa) {
            $rapor = Nilai::with('mataPelajaran')
                ->where('id_siswa', $siswa->id_siswa)
                ->get()
                ->groupBy(fn ($n) => $n->tahun_ajaran . ' - ' . $n->semester)
                ->map(fn ($items, $key) => [
                    'periode' => $key,
                    'nilai' => $items,
                    'rata_rata' => round($items->avg('nilai_akhir'), 2),
                ]);
        }

        return view('dashboard.siswa', compact('siswa', 'rapor'));
    }
}
