<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    //we have a category and it hasMany Post
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
