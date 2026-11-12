@extends('layouts.app')

@section('title', 'Tambah Project')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah Project</h1>

    {{-- enctype wajib ada, tanpa itu file tidak ikut terkirim --}}
    <form action="{{ route('post.projects.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">
        @csrf

        @include('posts.projects.form')

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Simpan
            </button>
            <a href="{{ route('post.projects.index') }}" class="py-2 px-4 rounded border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
