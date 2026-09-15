<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    protected $guarded =[];


    public function reffer()
    {
        return $this->belongsTo(User::class,'who');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
