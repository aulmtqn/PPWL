<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
{
    $search  = $request->input('search');
    $perPage = $request->input('per_page', 10);

    if (! in_array($perPage, [5, 10, 25])) {
        $perPage = 10;
    }

    $projects = Project::when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate($perPage)
        ->withQueryString();

    return view('projects.index', compact('projects', 'search', 'perPage'));
}

    public function create ()
    {
        return view ('projects.create');
    }




    public function store(Request $request)
{
    // 1. Validasi input
    $request->validate([
        'title' => 'required',
        'description' => 'required',
    ]);

    // 2. Menyimpan data ke database
    Project::create($request->all());

    // 3. Redirect kembali ke halaman index
    return redirect()->route('projects.index')
                     ->with('success', 'Data proyek berhasil ditambahkan.');
}

    public function edit(Project $project)
{
    
    return view('projects.edit', compact('project'));
}


    public function update(Request $request, string $id)
    {
    $validatedData = $request->validate([
    'title' => 'required|string|min:5',
    'description' => 'required|string|min:10',
    ]);
    $project = Project::findOrFail($id);
    $project->update($validatedData);
    return redirect()->route('projects.index')->with('success', 'Project Berhasil Diperbarui!');
    }


    public function destroy(string $id)
{
    $project = Project::findOrFail($id);
    
    // 1. Eksekusi hapus data dari database TERLEBIH DAHULU
    $project->delete();
    
    // 2. SETELAH terhapus, BARU alihkan ke halaman index
    return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus!');
}



}
