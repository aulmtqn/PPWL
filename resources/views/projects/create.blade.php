<!-- Cuplikan struktur form dengan Tailwind CSS -->
<form action="{{ route('projects.store') }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
    @csrf

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">
            Judul Proyek
        </label>
        <input type="text" name="title" class="w-full border border-gray-300 p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">
            Deskripsi
        </label>
        <textarea name="description" class="w-full border border-gray-300 p-2 rounded" rows="4" required></textarea>
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
        Simpan Data
    </button>
</form>