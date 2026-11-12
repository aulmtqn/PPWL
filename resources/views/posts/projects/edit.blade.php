@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Edit Project</h1>
        @if ($project->status === 'published')
            <a href="{{ route('projects.show', $project) }}" target="_blank" class="text-blue-600 hover:underline">
                Lihat halaman publik
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="p-3 bg-green-100 text-green-700 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form data project + ganti thumbnail --}}
    <form action="{{ route('post.projects.update', $project) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        @include('posts.projects.form')

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Update
            </button>
            <a href="{{ route('post.projects.index') }}" class="py-2 px-4 rounded border border-gray-300">Kembali</a>
        </div>
    </form>

    {{-- Gallery --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-1">Gallery</h2>
        <p class="text-sm text-gray-500 mb-4">
            {{ $project->images->count() }} / 10 gambar. Lebar minimal 800 px, maks 4 MB per gambar.
        </p>

        {{-- Upload banyak gambar sekaligus: name="images[]" + multiple --}}
        @if ($project->images->count() < 10)
            <form action="{{ route('post.projects.images.store', $project) }}" method="POST"
                  enctype="multipart/form-data" class="mb-6 flex flex-wrap items-center gap-2">
                @csrf
                <input type="file" name="images[]" accept="image/*" multiple>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Upload Gambar
                </button>
            </form>
        @else
            <p class="mb-6 text-sm text-orange-600">Gallery sudah penuh (10 gambar). Hapus gambar dulu untuk menambah.</p>
        @endif

        @error('images')
            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
        @enderror
        @foreach ($errors->get('images.*') as $messages)
            @foreach ($messages as $message)
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @endforeach
        @endforeach

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse ($project->images as $img)
                <div class="border rounded p-2 space-y-2">
                    <img src="{{ asset('storage/' . $img->image) }}"
                         alt="{{ $img->caption ?: $project->title }}"
                         class="w-full h-40 object-cover rounded">

                    {{-- Latihan mandiri: edit caption (route PUT) --}}
                    <form action="{{ route('post.projects.images.update', [$project, $img]) }}" method="POST"
                          class="flex gap-1">
                        @csrf
                        @method('PUT')
                        <input type="text" name="caption" value="{{ $img->caption }}" placeholder="Caption"
                               class="flex-1 min-w-0 border border-gray-300 p-1 rounded text-sm">
                        <button type="submit" class="bg-blue-500 text-white text-sm px-2 rounded">Simpan</button>
                    </form>

                    <form action="{{ route('post.projects.images.destroy', [$project, $img]) }}" method="POST"
                          onsubmit="return confirm('Hapus gambar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 text-sm hover:underline">Hapus gambar</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500">Belum ada gambar gallery.</p>
            @endforelse
        </div>
    </div>

    {{-- Hapus project --}}
    <form id="delete-form" action="{{ route('post.projects.destroy', $project) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" onclick="confirmDelete()"
                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
            Hapus Project
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Project, thumbnail, dan semua gambar gallery akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endsection
