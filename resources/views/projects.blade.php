@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Projects</h1>

    {{-- Form Search, Filter Kategori, dan Sorting --}}
    <form method="GET" action="{{ route('projects') }}" class="bg-white p-4 rounded-lg shadow mb-6 flex flex-wrap gap-3 items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari project..."
               class="flex-1 min-w-[200px] border border-gray-300 p-2 rounded">

        <select name="category" class="border border-gray-300 p-2 rounded">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->slug }}" @selected(request('category') === $c->slug)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="border border-gray-300 p-2 rounded">
            <option value="">Terbaru</option>
            <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
            <option value="az" @selected(request('sort') === 'az')>Judul (A-Z)</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Cari
        </button>
    </form>

    {{-- Daftar Kartu Project --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projects as $project)
            <a href="{{ route('projects.show', $project) }}"
               class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden block">
                @if ($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                        Tanpa thumbnail
                    </div>
                @endif
                <div class="p-4">
                    <span class="text-xs text-gray-500 uppercase">{{ $project->category->name ?? 'Tanpa Kategori' }}</span>
                    <h2 class="text-lg font-semibold text-gray-800">{{ $project->title }}</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $project->short_description ?: Str::limit($project->description, 80) }}
                    </p>

                    @if ($project->technologies->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mt-3">
                            @foreach ($project->technologies as $tech)
                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded">
                                    {{ $tech->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-gray-500 col-span-full">Tidak ada project yang cocok.</p>
        @endforelse
    </div>

    {{-- Navigasi Pagination --}}
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
</div>
@endsection