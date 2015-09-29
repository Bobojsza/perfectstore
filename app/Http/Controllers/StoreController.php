<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Distributor;
use App\Store;
use App\AuditTemplate;
use App\GradeMatrix;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stores = Store::with('distributor')->get();
        return view('store.index',compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $distributors = Distributor::getLists();
        $audittemplates = AuditTemplate::getLists();
        $passings = GradeMatrix::getLists();
        return view('store.create',compact('distributors', 'audittemplates', 'passings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'store' => 'required|max:100|unique_with:stores, store_code = store_code, distributor = distributor_id',
            'store_code' => 'required|not_in:0',
            'distributor' => 'required|not_in:0'
        ]);

        \DB::beginTransaction();

        try {
            $store = new Store;
            $store->distributor_id = $request->distributor;
            $store->store_code = $request->store_code;
            $store->store = $request->store;
            $store->save();

            \DB::commit();

            Session::flash('flash_message', 'Store successfully added!');
            return redirect()->route("store.index");

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
