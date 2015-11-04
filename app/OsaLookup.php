<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OsaLookup extends Model
{
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

    public function store()
    {
        return $this->belongsTo('App\Store','store_id','id');
    }

    public function template()
    {
        return $this->belongsTo('App\AuditTemplate','template_id','id');
    }

    public function categories(){
        return $this->hasMany('App\OsaLookupTarget','osa_lookup_id', 'id');
    }
}
