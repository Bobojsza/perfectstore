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



    public static function getOsaCategory($id){
        $store = Store::find($id);

        // store level
        $template = self::where('store_id',$store->id)->first(); 
        if(!empty($template)){ 
            return $template; //0001
        }

        $template = self::where('customer_id',$store->customer_id)->get();
        if(count($template) > 0){

            $template = self::where('customer_id',$store->customer_id)
                ->where('region_id',$store->region_id)
                ->get();
            if(count($template) > 0){

                $template = self::where('customer_id',$store->customer_id)
                    ->where('region_id',$store->region_id)
                    ->where('distributor_id',$store->distributor_id)
                    ->get();
                if(count($template) > 0){
                    $template = self::where('customer_id',$store->customer_id)
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                    if(!empty($template)){ 
                        return $template; //1111
                    }else{
                        return self::where('customer_id',$store->customer_id) //1110
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',0)
                        ->first();
                    }
                }else{
                    $template = self::where('customer_id',$store->customer_id)
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',0)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                    if(!empty($template)){ 
                        return $template; //1101
                    }else{
                        return self::where('customer_id',$store->customer_id) //1100
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',0)
                        ->where('template_id',0)
                        ->first();
                    }
                }
            }else{
                $template = self::where('customer_id',$store->customer_id)
                    ->where('region_id',0)
                    ->where('distributor_id',$store->distributor_id)
                    ->get();
                if(count($template) > 0){
                    $template = self::where('customer_id',$store->customer_id)
                        ->where('region_id',0)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                    if(!empty($template)){ 
                        return $template; //1011
                    }else{
                        return self::where('customer_id',$store->customer_id) //1010
                        ->where('region_id',0)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',0)
                        ->first();
                    }
                }else{
                    $template = self::where('customer_id',$store->customer_id)
                        ->where('region_id',0)
                        ->where('distributor_id',0)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                     if(!empty($template)){ 
                        return $template; //1001
                    }else{
                        return self::where('customer_id',$store->customer_id) //1000
                        ->where('region_id',0)
                        ->where('distributor_id',0)
                        ->where('template_id',0)
                        ->first();
                    }
                }
            }
        }else{
            $template = self::where('customer_id',0)
                ->where('region_id',$store->region_id)
                ->get();
            if(count($template) > 0){
                $template = self::where('customer_id',0)
                    ->where('region_id',$store->region_id)
                    ->where('distributor_id',$store->distributor_id)
                    ->get();
                if(count($template) > 0){
                    $template = self::where('customer_id',0) 
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                     if(!empty($template)){ 
                        return $template; //0111
                    }else{
                        return self::where('customer_id',0) // 0110
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',0)
                        ->first();
                    }
                }else{
                    $template = self::where('customer_id',0) 
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',0)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                    if(!empty($template)){ 
                        return $template; //0101
                    }else{
                        return self::where('customer_id',0) // 0100
                        ->where('region_id',$store->region_id)
                        ->where('distributor_id',0)
                        ->where('template_id',0)
                        ->first();
                    }
                }
            }else{
                $template = self::where('customer_id',0)
                    ->where('region_id',0)
                    ->where('distributor_id',$store->distributor_id)
                    ->get();
                if(count($template) > 0){
                    $template = self::where('customer_id',0)
                        ->where('region_id',0)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                     if(!empty($template)){ 
                        return $template; // 0011
                    }else{
                        return self::where('customer_id',0) //0010
                        ->where('region_id',0)
                        ->where('distributor_id',$store->distributor_id)
                        ->where('template_id',0)
                        ->first();
                    }
                }else{
                    $template = self::where('customer_id',0)
                        ->where('region_id',0)
                        ->where('distributor_id',0)
                        ->where('template_id',$store->audit_template_id)
                        ->first();
                     if(!empty($template)){ 
                        return $template; // 0001
                    }else{
                        return self::where('customer_id',0) // 0000
                            ->where('region_id',0)
                            ->where('distributor_id',0)
                            ->where('template_id',0)
                            ->where('store_id',0)
                            ->first();
                    }
                }
            }
            
        }

        

        

      
    }
}
