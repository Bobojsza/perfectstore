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

    public function audittemplate()
    {
        return $this->belongsTo('App\AuditTemplate','audit_template_id','id');
    }

    public function gradematrix()
    {
        return $this->belongsTo('App\GradeMatrix','grade_matrix_id','id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
