<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    public function index()
    {
        return view('posts.skills.index', [
            'skills' => Skill::orderByDesc('percentage')->get(),
        ]);
    }

    public function edit(Skill $skill)
    {
        return view('posts.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100', Rule::unique('skills', 'name')->ignore($skill->id)],
            'level'      => ['required', Rule::in(['Beginner', 'Intermediate', 'Advanced'])],
            'percentage' => ['required', 'integer', 'between:0,100'],
        ]);

        $skill->update($validated);

        return redirect()->route('post.skills.index')
            ->with('success', 'Skill berhasil diperbarui.');
    }
}
