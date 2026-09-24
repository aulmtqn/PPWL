<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $data = array (
        'id' => " projects",
        'projects' => Project :: all()
    );
    return view ('projects.index') ->with ( $data );
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
    return redirect()->route('projects.index');
    }



}
