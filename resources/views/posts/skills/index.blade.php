@extends('layouts.app')

@section('title', 'Kelola Skill')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Kelola Skill</h1>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Level</th>
                    <th class="py-3 px-4 text-left">Persentase</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($skills as $skill)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $skill->name }}</td>
                        <td class="py-3 px-4">{{ $skill->level ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $skill->percentage }}%</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('post.skills.edit', $skill) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-4 text-center text-gray-500">Belum ada skill.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
