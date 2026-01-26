<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HtmlCast;

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
    protected function casts(): array
    {
        $casts = [
            'order' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

        // Aggiungi il cast per content solo se la classe esiste
        if (class_exists(\App\Casts\HtmlCast::class)) {
            $casts['content'] = \App\Casts\HtmlCast::class;
        }

        return $casts;
    }
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
