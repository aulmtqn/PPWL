<?php

namespace Database\Seeders;
use App\Models\Project;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 40; $i++) {
            Project::create([
                'title'       => 'Project Judul Ke-' . $i,
                'description' => 'Deskripsi untuk project judul ke-' . $i,
            ]);
        }
    }
}
