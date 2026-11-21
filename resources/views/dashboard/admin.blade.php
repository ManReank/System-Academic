@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    @foreach([
        ['label' => 'Total Siswa', 'value' => $stats['siswa'], 'color' => 'blue'],
        ['label' => 'Total Guru', 'value' => $stats['guru'], 'color' => 'green'],
        ['label' => 'Total Kelas', 'value' => $stats['kelas'], 'color' => 'purple'],
        ['label' => 'Mata Pelajaran', 'value' => $stats['mapel'], 'color' => 'yellow'],
        ['label' => 'Jadwal', 'value' => $stats['jadwal'], 'color' => 'indigo'],
        ['label' => 'Data Nilai', 'value' => $stats['nilai'], 'color' => 'pink'],
    ] as $card)
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-{{ $card['color'] }}-500">
            <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $card['value'] }}</p>
        </div>
    @endforeach
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="font-semibold text-gray-800 mb-2">Nilai Rata-rata Keseluruhan</h3>
    <p class="text-4xl font-bold text-blue-600">{{ $nilaiRata }}</p>
    <p class="text-sm text-gray-500 mt-1">Dari {{ $stats['nilai'] }} data nilai</p>
</div>
@endsection
