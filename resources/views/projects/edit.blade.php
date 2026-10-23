@extends('layouts.app')

@section('content')
 <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
 <h1 class="text-3xl font-bold text-gray-900 mb-4">Edit Project</h1>
 
 @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="bg-red-500 text-white p-4 rounded mb-4">{{ $error }}</div>
     @endforeach
 @endif

 <!-- Ubah posts.update menjadi projects.update dan $post menjadi $project -->
 <form action="{{ route('projects.update', $project->id) }}" method="post">
     @csrf
     @method('PUT')
     
     <div class="mb-4">
         <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
         <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required class="border border-gray-300 p-2 rounded w-full">
     </div>
     
     <div class="mb-4">
         <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
         <!-- Ubah $post menjadi $project -->
         <textarea name="description" id="description" class="border border-gray-300 p-2 rounded w-full" required>{{ old('description', $project->description) }}</textarea>
     </div>
     <div class="flex items-center gap-4">
    <!-- Tombol Submit untuk Update (Tetap) -->
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Submit</button>
</form> <!-- Penutup form edit -->

<!-- Form Delete -->
<form id="delete-form" action="{{ route('projects.destroy', $project->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="button" onclick="confirmDelete()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Hapus</button>
</form>
</div>
 </form>
 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data project ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Warna merah mirip bg-red-500 Tailwind
            cancelButtonColor: '#6b7280', // Warna abu-abu untuk batal
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            // Jika user menekan tombol "Ya, Hapus!"
            if (result.isConfirmed) {
                // Eksekusi form submit
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endsection