<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        return view('posts.projects.create', [
            'categories'   => Category::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $technologyIds = $validated['technologies'] ?? [];
        unset($validated['technologies']); // bukan kolom tabel projects

        $project = Project::create($validated);
        $project->technologies()->attach($technologyIds);

        return redirect()->route('post.projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        $project->load(['technologies', 'images']);

        return view('posts.projects.edit', [
            'project'      => $project,
            'categories'   => Category::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate($this->rules($project));
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $technologyIds = $validated['technologies'] ?? [];
        unset($validated['technologies']);

        $project->update($validated);
        $project->technologies()->sync($technologyIds);

        return redirect()->route('post.projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->delete();

        return redirect()->route('post.projects.index')
            ->with('success', 'Project dihapus.');
    }

    private function rules(?Project $project = null): array
    {
        return [
            'title'             => ['required', 'string', 'max:255', Rule::unique('projects', 'title')->ignore($project?->id)],
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|max:255',
            'description'       => 'nullable|string',
            'status'            => 'required|in:draft,published',
            'project_date'      => 'nullable|date',
            'project_url'       => 'nullable|url|max:255',
            'repository_url'    => 'nullable|url|max:255',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
            'technologies'      => 'nullable|array',
            'technologies.*'    => 'exists:technologies,id',
        ];
    }
}