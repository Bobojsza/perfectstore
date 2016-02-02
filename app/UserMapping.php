<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMapping extends Model
{
	protected $fillable = ['user_name', 'start_date', 'end_date', 'mapped_stores'];
    public $timestamps = false;
}
