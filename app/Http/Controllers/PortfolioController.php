<?php

namespace App\Http\Controllers;

use App\Models\Project;

class PortfolioController extends Controller
{
    // Halaman publik hanya menampilkan project berstatus published
    public function projects()
    {
        return view('projects', [
            'projects' => Project::with('category')
                ->where('status', 'published')
                ->latest()
                ->get(),
        ]);
    }

    public function show(Project $project)
    {
        abort_if($project->status !== 'published', 404);

        $project->load(['category', 'images']);

        return view('portofolio.project', compact('project'));
    }
}
