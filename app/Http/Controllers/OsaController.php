<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use App\Customer;
use App\Region;
use App\Distributor;
use App\AuditTemplate;
use App\FormCategory;
use App\Store;
use App\OsaLookup;
use App\OsaLookupTarget;

class OsaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $osas = OsaLookup::with('customer')
            ->with('region')
            ->with('distributor')
            ->with('store')
            ->with('template')
            ->get();
        return view('osalookup.index', compact('osas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::getLists();
        $regions = Region::getLists();
        $distributors = Distributor::getLists();
        $templates = AuditTemplate::getLists();
        $categories = FormCategory::osaTagging();
        $stores = Store::getLists();
        return view('osalookup.create', compact('customers', 'regions', 'distributors', 'templates', 'categories', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'unique_with' => 'This combination of selection already exists.',
        ];
        $this->validate($request, [
            'customer_id' => 'required|unique_with:osa_lookups, regions = region_id, distributors = distributor_id, stores = store_id, templates = template_id',
            'regions' => 'required',
            'distributors' => 'required',
            'stores' => 'required',
            'templates' => 'required'
        ],$messages);

        \DB::beginTransaction();

        try {
            $lookup = new OsaLookup;
            $lookup->customer_id = $request->customer_id;
            $lookup->region_id = $request->regions;
            $lookup->distributor_id = $request->distributors;
            $lookup->store_id = $request->stores;
            $lookup->template_id = $request->templates;
            $lookup->save();

            foreach ($request->target as $category_id => $value) {
                if($category_id > 0){
                    if(!empty($value)){
                        $newlookup = new OsaLookupTarget;
                        $newlookup->osa_lookup_id = $lookup->id;
                        $newlookup->category_id = $category_id;
                        $newlookup->target = $value;
                        $newlookup->total = $request->total[$category_id];
                        $newlookup->save();
                    }
                    
                } 
            }

            \DB::commit();

            Session::flash('flash_message', 'OSA Lookup successfully added!');
            return redirect()->route("osalookup.index");

        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lookup = OsaLookup::with('categories')->findOrFail($id);
        $customers = Customer::getLists();
        $regions = Region::getLists();
        $distributors = Distributor::getLists();
        $templates = AuditTemplate::getLists();
        $categories = FormCategory::osaTagging();
        $stores = Store::getLists();


        return view('osalookup.edit',compact('lookup', 'sostags', 'customers','regions',
            'distributors','templates', 'categories', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lookup = OsaLookup::findOrFail($id);
        $messages = [
            'unique_with' => 'This combination of selection already exists.',
        ];
        $this->validate($request, [
            'customer_id' => 'required|unique_with:osa_lookups, regions = region_id, distributors = distributor_id, stores = store_id, templates = template_id,'.$id,
            'regions' => 'required',
            'distributors' => 'required',
            'stores' => 'required',
            'templates' => 'required'
        ],$messages);

        \DB::beginTransaction();

        try {
            $lookup->customer_id = $request->customer_id;
            $lookup->region_id = $request->regions;
            $lookup->distributor_id = $request->distributors;
            $lookup->store_id = $request->stores;
            $lookup->template_id = $request->templates;
            $lookup->update();

            OsaLookupTarget::where('osa_lookup_id',$lookup->id)->delete();
            foreach ($request->target as $category_id => $value) {
                if($category_id > 0){
                    if(!empty($value)){
                        $newlookup = new OsaLookupTarget;
                        $newlookup->osa_lookup_id = $lookup->id;
                        $newlookup->category_id = $category_id;
                        $newlookup->target = $value;
                        $newlookup->total = $request->total[$category_id];
                        $newlookup->save();
                    }
                    
                } 
            }

            \DB::commit();

            Session::flash('flash_message', 'OSA Lookup successfully updated!');
            return redirect()->route("osalookup.edit",[$id]);

        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
