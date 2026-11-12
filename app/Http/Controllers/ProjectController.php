<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [5, 10, 25])) {
            $perPage = 10;
        }

        $projects = Project::with('category')
            ->withCount('images')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('posts.projects.index', compact('projects', 'search', 'perPage'));
    }

    public function create()
    {
        // Dropdown kategori butuh data dari tabel categories
        return view('posts.projects.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('thumbnail')) {
            // Selalu tulis disk 'public', kalau tidak file masuk disk local dan tidak bisa dibuka browser
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        Project::create($validated);

        return redirect()->route('post.projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        $project->load('images');

        return view('posts.projects.edit', [
            'project'    => $project,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama dulu supaya tidak menumpuk di storage
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($validated);

        return redirect()->route('post.projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        // Hapus thumbnail dan semua gambar gallery dari storage
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->delete(); // baris project_images ikut hilang (cascadeOnDelete)

        return redirect()->route('post.projects.index')
            ->with('success', 'Project dihapus.');
    }

    // Aturan validasi dipakai bersama oleh store() dan update()
    private function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:draft,published',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp'
                           . '|max:2048|dimensions:min_width=400,min_height=300',
        ];
    }
}
