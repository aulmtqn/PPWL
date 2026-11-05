<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\Technology;
use App\Models\Skill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProjects' => Project::count(),
            'totalCategories' => Category::count(),
            'totalTechnologies' => Technology::count(),
            'totalSkills' => Skill::count(),
            'latestProjects' => Project::with('category')->latest()->take(5)->get(),
        ]);
    }
}