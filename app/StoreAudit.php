<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreAudit extends Model
{
  public function audit_details()
  {
      return $this->hasMany('App\StoreAuditDetails');
  }
}
