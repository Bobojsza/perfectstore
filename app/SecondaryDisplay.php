<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondaryDisplay extends Model
{
    public $timestamps = false;

    public function category(){
    	return $this->belongsTo('App\FormCategory', 'category_id', 'id');
    }

   
}
