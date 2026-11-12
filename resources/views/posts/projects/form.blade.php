{{-- Field form project, dipakai di create dan edit. $project boleh null (saat create). --}}
@php
    $project = $project ?? null;
    $selectedTechs = old('technologies', $project?->technologies->pluck('id')->all() ?? []);
@endphp

<div class="mb-4">
    <label for="title" class="block text-gray-700 font-bold mb-2">Judul Project</label>
    <input type="text" name="title" id="title" value="{{ old('title', $project?->title) }}"
           class="w-full border border-gray-300 p-2 rounded">
    @error('title')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="short_description" class="block text-gray-700 font-bold mb-2">Ringkasan Singkat</label>
    <input type="text" name="short_description" id="short_description"
           value="{{ old('short_description', $project?->short_description) }}"
           placeholder="Ringkasan pendek untuk kartu project"
           class="w-full border border-gray-300 p-2 rounded">
    @error('short_description')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi Lengkap</label>
    <textarea name="description" id="description" rows="4"
              class="w-full border border-gray-300 p-2 rounded">{{ old('description', $project?->description) }}</textarea>
    @error('description')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori</label>
    <select name="category_id" id="category_id" class="w-full border border-gray-300 p-2 rounded">
        <option value="">Pilih kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @selected(old('category_id', $project?->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-bold mb-2">Technologies</label>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
        @foreach ($technologies as $tech)
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="technologies[]" value="{{ $tech->id }}"
                       @checked(in_array($tech->id, $selectedTechs))
                       class="rounded border-gray-300">
                <span>{{ $tech->name }}</span>
            </label>
        @endforeach
    </div>
    @error('technologies')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
    @error('technologies.*')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
    <div>
        <label for="project_date" class="block text-gray-700 font-bold mb-2">Tanggal Project</label>
        <input type="date" name="project_date" id="project_date"
               value="{{ old('project_date', $project?->project_date) }}"
               class="w-full border border-gray-300 p-2 rounded">
        @error('project_date')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="project_url" class="block text-gray-700 font-bold mb-2">URL Project</label>
        <input type="url" name="project_url" id="project_url"
               value="{{ old('project_url', $project?->project_url) }}"
               placeholder="https://..."
               class="w-full border border-gray-300 p-2 rounded">
        @error('project_url')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="repository_url" class="block text-gray-700 font-bold mb-2">URL Repository</label>
        <input type="url" name="repository_url" id="repository_url"
               value="{{ old('repository_url', $project?->repository_url) }}"
               placeholder="https://github.com/..."
               class="w-full border border-gray-300 p-2 rounded">
        @error('repository_url')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mb-4">
    <label for="status" class="block text-gray-700 font-bold mb-2">Status</label>
    <select name="status" id="status" class="w-full border border-gray-300 p-2 rounded">
        @foreach (['draft' => 'Draft', 'published' => 'Published'] as $value => $label)
            <option value="{{ $value }}" @selected(old('status', $project?->status ?? 'draft') === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('status')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="thumbnail" class="block text-gray-700 font-bold mb-2">Thumbnail</label>
    @if ($project?->thumbnail)
        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
             class="w-48 h-32 object-cover rounded mb-2">
        <p class="text-xs text-gray-500 mb-2">Pilih file baru untuk mengganti. File lama akan dihapus.</p>
    @endif
    <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
    <p class="text-xs text-gray-500">JPG/PNG/WEBP, maks 2 MB, minimal 400x300 px.</p>
    @error('thumbnail')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>