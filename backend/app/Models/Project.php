<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

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

    public function getRouteKeyName()
    {
        return 'slug'; // Usa slug nelle URL invece di ID
    }
}
