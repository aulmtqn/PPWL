<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Seeder;

class RandomProjectGenerator extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id');

        for ($i = 1; $i <= 25; $i++) {
            Project::create([
                'title'       => fake()->sentence(3),
                'description' => fake()->paragraph(2),
                'category_id' => $categoryIds->isNotEmpty() ? $categoryIds->random() : null,
                'status'      => fake()->randomElement(['published', 'draft']),
            ]);
        }
    }
}
