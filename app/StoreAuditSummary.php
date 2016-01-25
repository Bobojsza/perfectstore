<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreAuditSummary extends Model
{
    public static function getUniqueCategory($id){
    	return self::where('store_audit_id',$id)
    		->groupBy('category')
    		->orderBy('id')
    		->get();
    }

    public static function getUniqueGroup($id){
    	return self::where('store_audit_id',$id)
    		->groupBy('group')
    		->orderBy('id')
    		->get();
    }
}
