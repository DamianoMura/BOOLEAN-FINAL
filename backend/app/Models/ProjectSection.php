<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSection extends Model
{
    //
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'content',
        'order',
        'last_edited_by',
        'published'
    ];

    public function project()
    {

        return $this->belongsTo(Project::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function lastEditedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
