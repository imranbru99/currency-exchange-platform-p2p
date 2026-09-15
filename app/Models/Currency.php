<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $guarded = [];


    public function gateway_currency()
    {
        return $this->belongsTo(Gateway::class, 'payment_type_buy');
    }
    
}
