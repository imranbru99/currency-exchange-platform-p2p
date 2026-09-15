<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function post(){
    	return $this->hasMany(Post::class, 'sub_category_id', 'id')->where('status', 1)->orderBy('id', 'ASC');
    }

}
