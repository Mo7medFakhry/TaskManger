<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasApiTokens;

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'category_task');
    }
}
