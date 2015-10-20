<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondaryDisplayLookup extends Model
{
    public $timestamps = false;

    protected $fillable = ['store_id', 'secondary_display_id'];

    public static function getStores(){
    	return self::select('stores.id', 'stores.store_code', 'stores.store')
    		->join('stores', 'secondary_display_lookups.store_id','=','stores.id')
    		->groupBy('store')
    		->orderBy('store')
    		->get();
    }

    public static function getLists($id){
    	$records = self::select('secondary_display_id')
    		->where('store_id',$id)
    		->get();
    	$data = array();
    	foreach ($records as $value) {
    		$data[] = $value->secondary_display_id;
    	}
    	return $data;
    }

}

