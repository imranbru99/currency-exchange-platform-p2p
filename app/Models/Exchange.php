<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment_from_getway()
    {
        return $this->belongsTo(Currency::class,'payment_from');
    }

    public function payment_to_getway()
    {
        return $this->belongsTo(Currency::class,'payment_to');
    }

    public function deposit(){
        return $this->hasOne(Deposit::class,'deposit_id');
    }

    
}
