<?php

namespace App\Models;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
    protected $fillable = ['author_id', 'slug', 'title', 'description', 'category_id', 'published'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function technology()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function editor()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
    // Verifica se un utente è assegnato al progetto
    public function hasUserAssigned($userId)
    {
        return $this->editor()->where('user_id', $userId)->exists();
    }
    // slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $project->slug = $project->slug ?: Str::slug($project->title);
            $project->slug = $project->makeSlugUnique($project->slug);
        });

        static::updating(function ($project) {
            if ($project->isDirty('title') && !$project->isDirty('slug')) {
                $project->slug = $project->makeSlugUnique(Str::slug($project->title));
            }
        });
    }

    public function makeSlugUnique(string $slug): string
    {
        if (empty($slug)) {
            $slug = 'project-' . uniqid();
        }

        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)
            ->where('id', '!=', $this->id ?? 0)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;

            if ($counter > 100) {
                $slug = $originalSlug . '-' . uniqid();
                break;
            }
        }

        return $slug;
    }
    /**
     * Route model binding con slug
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
