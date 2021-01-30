<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }    

    public static function getAllProjects()
    {
        $projects =  Project::with('tasks')->orderBy('created_at', 'desc')->get()->toArray();
        return $projects;
    }

}
