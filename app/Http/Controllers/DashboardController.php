<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Technology;

class DashboardController extends Controller
{
    public function index()
    {
        // Semua angka dihitung di database dengan count(), bukan all()->count()
        return view('posts.dashboard', [
            'totalProjects'     => Project::count(),
            'totalCategories'   => Category::count(),
            'totalTechnologies' => Technology::count(),
            'totalSkills'       => Skill::count(),

            // Latihan mandiri: Published + Draft = Total Projects
            'totalPublished'    => Project::where('status', 'published')->count(),
            'totalDraft'        => Project::where('status', 'draft')->count(),

            // Latihan mandiri: skill dengan persentase tertinggi
            'topSkill'          => Skill::orderByDesc('percentage')->first(),

            // Latihan mandiri: jumlah project per kategori dengan withCount()
            'categories'        => Category::withCount('projects')->orderBy('name')->get(),

            'latestProjects'    => Project::with('category')->latest()->take(5)->get(),
        ]);
    }
}
