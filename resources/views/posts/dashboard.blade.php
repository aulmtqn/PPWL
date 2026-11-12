@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>

    {{-- Card statistik utama --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-stat-card label="Projects"     :value="$totalProjects" />
        <x-stat-card label="Categories"   :value="$totalCategories" color="text-green-600" />
        <x-stat-card label="Technologies" :value="$totalTechnologies" color="text-purple-600" />
        <x-stat-card label="Skills"       :value="$totalSkills" color="text-orange-600" />
    </div>

    {{-- Latihan mandiri: Published / Draft / Skill Teratas --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <x-stat-card label="Published" :value="$totalPublished" color="text-emerald-600" />
        <x-stat-card label="Draft"     :value="$totalDraft" color="text-gray-600" />
        <x-stat-card label="Skill Teratas"
                     :value="$topSkill ? $topSkill->name . ' (' . $topSkill->percentage . '%)' : '-'"
                     color="text-pink-600" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Latihan mandiri: jumlah project per kategori (withCount) --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Project per Kategori</h2>
            <ul class="divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <li class="py-2 flex justify-between">
                        <span>{{ $category->name }}</span>
                        <span class="font-semibold">{{ $category->projects_count }}</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">Belum ada kategori.</li>
                @endforelse
            </ul>
        </div>

        {{-- 5 project terbaru --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">5 Project Terbaru</h2>
            <ul class="divide-y divide-gray-200">
                @forelse ($latestProjects as $project)
                    <li class="py-2 flex justify-between gap-4">
                        <a href="{{ route('post.projects.edit', $project) }}" class="text-blue-600 hover:underline">
                            {{ $project->title }}
                        </a>
                        <span class="text-sm text-gray-500 whitespace-nowrap">
                            {{ $project->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">Belum ada project.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
