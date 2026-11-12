@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Projects</h1>

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
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($project->description, 80) }}</p>
                </div>
            </a>
        @empty
            <p class="text-gray-500">Belum ada project yang dipublikasikan.</p>
        @endforelse
    </div>
</div>
@endsection
