<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProjectGalleryController extends Controller
{
    // Batas jumlah gambar gallery per project (latihan mandiri)
    private const MAX_IMAGES = 10;

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images'   => 'required|array|max:' . self::MAX_IMAGES,
            // Latihan mandiri: lebar minimal 800 px
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=800',
        ], [
            'images.*.dimensions' => 'Lebar gambar gallery minimal 800 px.',
        ]);

        $files     = $request->file('images');
        $existing  = $project->images()->count();
        $remaining = self::MAX_IMAGES - $existing;

        // Latihan mandiri: total gambar (lama + baru) tidak boleh lebih dari 10
        if (count($files) > $remaining) {
            throw ValidationException::withMessages([
                'images' => "Maksimal " . self::MAX_IMAGES . " gambar per project. "
                          . "Sudah ada {$existing}, sisa slot {$remaining}.",
            ]);
        }

        $order = (int) $project->images()->max('sort_order');

        foreach ($files as $file) {
            $project->images()->create([
                'image'      => $file->store('projects/gallery', 'public'),
                'sort_order' => ++$order,
            ]);
        }

        return back()->with('success', count($files) . ' gambar ditambahkan ke gallery.');
    }

    // Latihan mandiri: edit caption gambar (route PUT)
    public function update(Request $request, Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $image->update($validated);

        return back()->with('success', 'Caption diperbarui.');
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        // Pastikan gambar memang milik project ini
        abort_if($image->project_id !== $project->id, 404);

        Storage::disk('public')->delete($image->image); // file fisik dulu
        $image->delete();                               // lalu baris database

        return back()->with('success', 'Gambar dihapus.');
    }
}
