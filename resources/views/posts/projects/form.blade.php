{{-- Field form project, dipakai di create dan edit. $project boleh null (saat create). --}}
@php($project = $project ?? null)

<div class="mb-4">
    <label for="title" class="block text-gray-700 font-bold mb-2">Judul Project</label>
    <input type="text" name="title" id="title" value="{{ old('title', $project?->title) }}"
           class="w-full border border-gray-300 p-2 rounded">
    @error('title')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
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
