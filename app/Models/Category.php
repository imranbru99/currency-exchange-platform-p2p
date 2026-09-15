<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function subCategory(){
    	return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    public function forum(){
    	return $this->belongsTo(Forum::class);
    }

    public function topics(){
        return $this->hasManyThrough(Post::class, SubCategory::class);
    }


}
