<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Region;
use App\Distributor;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $distributors = Distributor::with('region')->get();
        return view('distributor.index',compact('distributors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $regions = Region::getLists();
        return view('distributor.create',compact('regions'));
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
            'distributor' => 'required|max:100|unique_with:distributors, distributor_code = distributor_code, region = region_id',
            'distributor_code' => 'required|not_in:0',
            'region' => 'required|not_in:0'
        ]);

        \DB::beginTransaction();

        try {
            $distributor = new Distributor;
            $distributor->region_id = $request->region;
            $distributor->distributor_code = $request->distributor_code;
            $distributor->distributor = $request->distributor;
            $distributor->save();

            \DB::commit();

            Session::flash('flash_message', 'Distributor successfully added!');
            return redirect()->route("distributor.index");

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
