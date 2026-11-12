<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Hanya kolom di $fillable yang boleh diisi lewat create()/update() (mass assignment).
    // Tanpa 'thumbnail' di sini, path gambar tidak akan tersimpan walau tidak ada error.
    protected $fillable = [
    'title', 'slug', 'category_id', 'short_description', 'description',
    'status', 'project_date', 'is_featured', 'project_url',
    'repository_url', 'thumbnail', 'name'
    ];

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
    

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Satu project punya banyak gambar gallery, diurutkan berdasarkan sort_order
    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}
