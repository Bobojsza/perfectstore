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
        //
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
        //
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
        //
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
