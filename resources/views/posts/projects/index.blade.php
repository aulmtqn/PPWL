@extends('layouts.app')

@section('title', 'Kelola Project')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Project</h1>
        <a href="{{ route('post.projects.create') }}"
           class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Tambah Project
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-4 flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul..."
               class="border border-gray-300 rounded p-2">
        <select name="per_page" onchange="this.form.submit()" class="border border-gray-300 rounded p-2">
            @foreach ([5, 10, 25] as $jumlah)
                <option value="{{ $jumlah }}" @selected($perPage == $jumlah)>{{ $jumlah }} per halaman</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-800 text-white px-4 rounded">Cari</button>
    </form>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Thumbnail</th>
                    <th class="py-3 px-4 text-left">Judul Project</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Gallery</th>
                    <th class="py-3 px-4 text-left">Tanggal Dibuat</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($projects as $project)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $projects->firstItem() + $loop->index }}</td>
                        <td class="py-3 px-4">
                            @if ($project->thumbnail)
                                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
                                     class="w-20 h-14 object-cover rounded">
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $project->title }}</td>
                        <td class="py-3 px-4">{{ $project->category->name ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $project->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-200 text-gray-700' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $project->images_count }} gambar</td>
                        <td class="py-3 px-4">{{ $project->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('post.projects.edit', $project) }}"
                               class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 text-center text-gray-500">Belum ada data project.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-sm text-gray-600">
        Halaman: {{ $projects->currentPage() }} ·
        Jumlah data: {{ $projects->total() }} ·
        Data per halaman: {{ $projects->perPage() }}
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
@endsection
