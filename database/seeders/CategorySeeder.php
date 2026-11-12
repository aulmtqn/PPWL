<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Dropdown kategori butuh minimal satu baris di tabel categories
        foreach (['Web', 'Mobile', 'Desain'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
