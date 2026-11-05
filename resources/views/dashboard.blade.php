<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Bagian Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <div class="text-sm text-gray-500">Total Projects</div>
                    <div class="text-2xl font-bold">{{ $totalProjects }}</div>
                </div>
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <div class="text-sm text-gray-500">Total Categories</div>
                    <div class="text-2xl font-bold">{{ $totalCategories }}</div>
                </div>
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <div class="text-sm text-gray-500">Total Technologies</div>
                    <div class="text-2xl font-bold">{{ $totalTechnologies }}</div>
                </div>
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <div class="text-sm text-gray-500">Total Skills</div>
                    <div class="text-2xl font-bold">{{ $totalSkills }}</div>
                </div>
            </div>

            <!-- Bagian Latest Projects -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">5 Proyek Terbaru</h3>
                <ul class="divide-y divide-gray-200">
                    @forelse ($latestProjects as $project)
                        <li class="py-3 flex justify-between">
                            <div>
                                <p class="font-medium">{{ $project->title }}</p>
                                <p class="text-sm text-gray-500">{{ $project->description }}</p>
                            </div>
                            <span class="text-sm text-gray-600">
                                {{ $project->category->name ?? 'Tanpa Kategori' }}
                            </span>
                        </li>
                    @empty
                        <li class="py-3 text-gray-500">Belum ada proyek.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>