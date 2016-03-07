<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use App\UserMapping;
use App\StoreAudit;
use App\StoreAuditSummary;

class UserReportController extends Controller
{
    
    public function summary()
    {
        $users = DB::select('select user_mapping.id, store_audits.user_name,user_mapping.start_date,
         user_mapping.end_date, user_mapping.mapped_stores,store_visited.store_visited,perfect_stores.perfect_stores,
sum(user_mapping.mapped_stores - store_visited.store_visited) as pending_stores
from store_audits
left join (
	select * from user_mappings
) as user_mapping on store_audits.user_name = user_mapping.user_name
left join (
	select user_name, count(*) as perfect_stores from store_audits where passed = 1 group by user_name
) as perfect_stores on store_audits.user_name = perfect_stores.user_name
left join (
	select user_name, count(*) as store_visited from store_audits group by user_name
) as store_visited on store_audits.user_name = store_visited.user_name
group by store_audits.user_name,user_mapping.end_date ');
        // dd($users);
        return view('userreport.index',compact('users'));
    }


    public function details($id){
    	$mapped_user = UserMapping::findOrFail($id);
    	$stores = StoreAudit::where('user_name',$mapped_user->user_name )->get();
    	return view('userreport.details',compact('stores'));
    }

    public function storesummary($id){
    	$store_auidit = StoreAudit::findOrFail($id);
    	$summaries = StoreAuditSummary::raw("SELECT category,min(passed) as passed")
            ->where('store_audit_id',$store_auidit->id)	
    		->groupBy('category')
    		->get();
    	return view('userreport.storesummary',compact('summaries'));
    }

}
