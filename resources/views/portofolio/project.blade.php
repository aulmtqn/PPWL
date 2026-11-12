@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 space-y-6">
    <a href="{{ route('projects') }}" class="text-blue-600 hover:underline">&larr; Semua project</a>

    <div>
        <span class="text-sm text-gray-500 uppercase">{{ $project->category->name ?? 'Tanpa Kategori' }}</span>
        <h1 class="text-3xl font-bold text-gray-800">{{ $project->title }}</h1>
    </div>

    @if ($project->thumbnail)
        <img src="{{ asset('storage/' . $project->thumbnail) }}"
             alt="{{ $project->title }}"
             class="w-full max-h-[28rem] object-cover rounded-lg shadow">
    @endif

    <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>

    @if ($project->images->isNotEmpty())
        <h2 class="text-2xl font-semibold text-gray-800">Gallery</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($project->images as $img)
                <figure class="bg-white rounded-lg shadow overflow-hidden">
                    <img src="{{ asset('storage/' . $img->image) }}"
                         alt="{{ $img->caption ?: $project->title }}"
                         class="w-full h-48 object-cover">
                    {{-- Latihan mandiri: caption tampil di halaman publik --}}
                    @if ($img->caption)
                        <figcaption class="p-2 text-sm text-gray-600">{{ $img->caption }}</figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    @endif
</div>
@endsection
