<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin & User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('12345'),
        ]);

        // 2. Buat Data Dummy Skills & Technologies (Supaya Dashboard tidak 0)
        Skill::insert([
            ['name' => 'Web Development', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '3D Modeling', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'UI/UX Design', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Technology::insert([
            ['name' => 'Laravel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tailwind CSS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blender', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Panggil Seeder Category dan Project
        // Catatan: Pastikan nama file & class categorySeeder sudah diubah jadi CategorySeeder (C besar)
        $this->call([
            CategorySeeder::class,
            RandomProjectGenerator::class,
        ]);
    }
}