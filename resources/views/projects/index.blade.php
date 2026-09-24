@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <!-- Wrapper untuk tombol agar memiliki jarak dengan elemen di bawahnya -->
    <div class="mb-4">
        <a href="{{ route('projects.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Tambah Project
        </a>
    </div>

    <!-- Alert success dengan tampilan yang lebih rapi -->
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Wrapper tabel dengan overflow-x-auto agar responsif di layar kecil -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left border-b border-gray-700">No</th>
                    <th class="py-3 px-4 text-left border-b border-gray-700">Judul Project</th>
                    <th class="py-3 px-4 text-left border-b border-gray-700">Deskripsi</th>
                    <th class="py-3 px-4 text-left border-b border-gray-700">Tanggal Dibuat</th>
                    <th class="py-3 px-4 text-left border-b border-gray-700">Edit</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                @forelse ($projects as $index => $project)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            {{ $index + 1 }}
                        </td>
                        <td class="py-3 px-4">
                            {{ $project->title }}
                        </td>
                        <td class="py-3 px-4">
                            {{ Str::limit($project->description, 50) }}
                        </td>
                        <td class="py-3 px-4">
                            {{ $project->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('projects.edit', $project->id) }}" class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
    Edit
</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">
                            Belum ada data project.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection