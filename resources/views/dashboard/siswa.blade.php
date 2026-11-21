@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="font-semibold text-gray-800">Selamat datang, {{ $siswa->nama ?? auth()->user()->name }}</h3>
    <p class="text-sm text-gray-500 mt-1">
        Kelas: <span class="font-medium">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
    </p>
</div>

@if($rapor->isEmpty())
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-800">
        Belum ada data nilai.
    </div>
@else
    @foreach($rapor as $periode)
        <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
            <div class="bg-slate-800 text-white px-6 py-3 flex justify-between">
                <span class="font-semibold">{{ $periode['periode'] }}</span>
                <span>Rata-rata: <b>{{ $periode['rata_rata'] }}</b></span>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2">Mata Pelajaran</th>
                        <th class="text-right px-4 py-2">Tugas</th>
                        <th class="text-right px-4 py-2">UTS</th>
                        <th class="text-right px-4 py-2">UAS</th>
                        <th class="text-right px-4 py-2">Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periode['nilai'] as $n)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $n->mataPelajaran->nama_mapel }}</td>
                            <td class="text-right px-4 py-2">{{ $n->nilai_tugas }}</td>
                            <td class="text-right px-4 py-2">{{ $n->nilai_uts }}</td>
                            <td class="text-right px-4 py-2">{{ $n->nilai_uas }}</td>
                            <td class="text-right px-4 py-2 font-bold">{{ $n->nilai_akhir }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endif
@endsection
