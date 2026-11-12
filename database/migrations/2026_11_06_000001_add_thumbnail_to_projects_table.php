<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Kategori project (dropdown di form). Nullable supaya 25 data lama tetap valid.
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            // Path thumbnail di disk public, bukan file-nya
            $table->string('thumbnail')->nullable();
            // Latihan mandiri: status Published / Draft
            $table->string('status')->default('draft');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn(['thumbnail', 'status']);
        });
    }
};
