<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    public function forms()
    {
        return $this->hasMany('App\Form');
    }
}
