<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $timestamps = false;

     public function distributor()
    {
        return $this->belongsTo('App\Distributor','distributor_id','id');
    }
}
