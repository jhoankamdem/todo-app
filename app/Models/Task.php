<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'project_id', 'title', 'description', 'due_date', 'is_completed',
    ];

    // Relation entre Task et Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

