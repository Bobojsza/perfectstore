<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreAuditDetail extends Model
{
  public function store_audit()
  {
      return $this->belongsTo('App\StoreAudit');
  }

  public static function getDetails($id){
    return self::select('customer', 'template_name', 'region', 'distributor', 'store_code', 'store_name', 
      'created_at', 'category', 'group', 'prompt', 'answer')
      ->join('store_audits', 'store_audits.id', '=', 'store_audit_details.store_audit_id')
      ->where('store_audit_id', $id)
      ->orderBy('store_audit_details.id')
      ->get();
  }
}
