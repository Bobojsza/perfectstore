<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyImage extends Model
{
    public $timestamps = false;

    protected $fillable = ['images'];
}
