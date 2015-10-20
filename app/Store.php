<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $timestamps = false;

    protected $hidden = array('pivot');

    public function account()
    {
        return $this->belongsTo('App\Account','account_id','id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function region()
    {
        return $this->belongsTo('App\Region','region_id','id');
    }

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


    public static function getLists(){
        return self::select(\DB::raw('CONCAT(store_code, " - ", store) AS store_desc'), 'id')
        ->orderBy('store_desc')
        ->lists('store_desc','id')
        ->all();
    }

}
