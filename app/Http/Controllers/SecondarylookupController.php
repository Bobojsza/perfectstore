<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Store;
use App\FormCategory;
use App\SecondaryDisplayLookup;

class SecondarylookupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = SecondaryDisplayLookup::getStores();
        return view('secondarylookup.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::getLists();
        $categories = FormCategory::with(array('secondarybrand' => function($query) {
                $query->orderBy('brand');
            }))
            ->where('secondary_display',1)
            ->orderBy('category')
            ->get();
        return view('secondarylookup.create',compact('stores', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = Store::findOrFail($request->store_id);
        $this->validate($request, [
            'store_id' => 'required|not_in:0|unique_with:secondary_display_lookups',
            'brands' => 'required',
        ]);

        \DB::beginTransaction();

        try {
            
            foreach ($request->brands as $value) {
                SecondaryDisplayLookup::create(['store_id' => $store->id, 'secondary_display_id' => $value ]);
            }

            \DB::commit();

            Session::flash('flash_message', 'Secondary Display Lookup successfully added!');
            return redirect()->route("secondarylookup.index");

        } catch (Exception $e) {
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = Store::findOrFail($id);

        $stores = Store::getLists();
        $categories = FormCategory::with(array('secondarybrand' => function($query) {
                $query->orderBy('brand');
            }))
            ->where('secondary_display',1)
            ->orderBy('category')
            ->get();

        $list = SecondaryDisplayLookup::getLists($id);
        // dd($list);
        return view('secondarylookup.edit',compact('stores', 'categories', 'store', 'list'));
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
        dd(1);
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
