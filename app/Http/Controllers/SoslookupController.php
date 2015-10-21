<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\FormCategory;
use App\SosTagging;
use App\Customer;
use App\AuditTemplate;
use App\Region;
use App\Distributor;
use App\Store;
use App\SosLookup;
use App\SosLookupPercentage;

class SoslookupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lookups = SosLookup::with('customer')
            ->with('region')
            ->with('distributor')
            ->with('store')
            ->with('template')
            ->get();
        return view('soslookup.index',compact('lookups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sostags = SosTagging::all();
        $customers = Customer::getLists();
        $regions = Region::getLists();
        $distributors = Distributor::getLists();
        $templates = AuditTemplate::getLists();
        $categories = FormCategory::sosTagging();
        $stores = Store::getLists();
        return view('soslookup.create',compact('sostags', 'customers','regions',
            'distributors','templates', 'categories', 'stores'));
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
            'customer_id' => 'required|unique_with:sos_lookups, regions = region_id, distributors = distributor_id, stores = store_id, templates = template_id',
            'regions' => 'required',
            'distributors' => 'required',
            'stores' => 'required',
            'templates' => 'required'
        ],$messages);

        \DB::beginTransaction();

        try {
            $lookup = new SosLookup;
            $lookup->customer_id = $request->customer_id;
            $lookup->region_id = $request->regions;
            $lookup->distributor_id = $request->distributors;
            $lookup->store_id = $request->stores;
            $lookup->template_id = $request->templates;
            $lookup->save();

            foreach ($request->category as $category_id => $category) {
                $less = $category[0];
                foreach ($category as $key => $value) {
                    if($key > 0){
                        if(!empty($value)){
                            $newlookup = new SosLookupPercentage;
                            $newlookup->sos_lookup_id = $lookup->id;
                            $newlookup->category_id = $category_id;
                            $newlookup->sos_id = $key;
                            $newlookup->less = $less;
                            $newlookup->value = $value;
                            $newlookup->save();
                        }
                        
                    }
                } 
            }

            \DB::commit();

            Session::flash('flash_message', 'SOS Lookup successfully added!');
            return redirect()->route("soslookup.index");

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
        $lookup = SosLookup::with('categories')->findOrFail($id);

        $sostags = SosTagging::all();
        $customers = Customer::getLists();
        $regions = Region::getLists();
        $distributors = Distributor::getLists();
        $templates = AuditTemplate::getLists();
        $categories = FormCategory::sosTagging();
        $stores = Store::getLists();


        return view('soslookup.edit',compact('lookup', 'sostags', 'customers','regions',
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
        $lookup = SosLookup::findOrFail($id);
        $messages = [
            'unique_with' => 'This combination of selection already exists.',
        ];
        $this->validate($request, [
            'customer_id' => 'required|unique_with:sos_lookups, regions = region_id, distributors = distributor_id, stores = store_id, templates = template_id,'.$id,
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

            SosLookupPercentage::where('sos_lookup_id',$lookup->id)->delete();
            foreach ($request->category as $category_id => $category) {
                $less = $category[0];
                foreach ($category as $key => $value) {
                    if($key > 0){
                        if(!empty($value)){
                            $newlookup = new SosLookupPercentage;
                            $newlookup->sos_lookup_id = $lookup->id;
                            $newlookup->category_id = $category_id;
                            $newlookup->sos_id = $key;
                            $newlookup->less = $less;
                            $newlookup->value = $value;
                            $newlookup->save();
                        }
                        
                    }
                } 
            }

            \DB::commit();

            Session::flash('flash_message', 'SOS Lookup successfully updated!');
            return redirect()->route("soslookup.edit",[$id]);

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
