@extends('layouts.app')

@section('title', 'Edit Skill')

@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Skill</h1>

    <form action="{{ route('post.skills.update', $skill) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Skill</label>
            <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}"
                   class="w-full border border-gray-300 p-2 rounded">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="level" class="block text-gray-700 font-bold mb-2">Level</label>
            <select name="level" id="level" class="w-full border border-gray-300 p-2 rounded">
                <option value="">Pilih level</option>
                @foreach (['Beginner', 'Intermediate', 'Advanced'] as $level)
                    <option value="{{ $level }}" @selected(old('level', $skill->level) === $level)>{{ $level }}</option>
                @endforeach
            </select>
            @error('level')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="percentage" class="block text-gray-700 font-bold mb-2">Persentase (0-100)</label>
            <input type="number" name="percentage" id="percentage" min="0" max="100"
                   value="{{ old('percentage', $skill->percentage) }}"
                   class="w-full border border-gray-300 p-2 rounded">
            @error('percentage')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Update</button>
            <a href="{{ route('post.skills.index') }}" class="py-2 px-4 rounded border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
