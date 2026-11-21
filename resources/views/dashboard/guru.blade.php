@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach([
        ['label' => 'Jadwal Mengajar', 'value' => $stats['jadwal'], 'color' => 'blue'],
        ['label' => 'Kelas Diampu', 'value' => $stats['kelas'], 'color' => 'green'],
        ['label' => 'Nilai Diinput', 'value' => $stats['nilai'], 'color' => 'purple'],
    ] as $card)
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-{{ $card['color'] }}-500">
            <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $card['value'] }}</p>
        </div>
    @endforeach
</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
    Menu input nilai dan jadwal akan ditambahkan di iterasi selanjutnya.
</div>
@endsection
