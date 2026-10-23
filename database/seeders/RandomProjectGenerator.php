<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RandomProjectGenerator extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 25; $i++) {
            \App\Models\Project::create([
                'title' => fake()->sentence(3), // Generate a random title with 3 words
                'description' => fake()->paragraph(2), // Generate a random description with 2 paragraphs
            ]);
        }
    }
}
