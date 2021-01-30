<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points',
        'project_id'
    ];

    protected $casts = [
        'points' => 'integer',
        'project_id' => 'integer'        
    ];    

    public static function getAllTask()
    {
        return Task::All()->toArray();
    }

}
