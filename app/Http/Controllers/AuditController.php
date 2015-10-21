<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Audit;
use App\Customer;
use App\Region;
use App\Distributor;
use App\AuditTemplate;
use App\Store;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $audits = Audit::all();
        return view('audit.index',compact('audits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $customers = Customer::getLists();
        $regions = Region::getLists();
        $distributors = Distributor::getLists();
        $stores = Store::getLists();
        return view('audit.create',compact('customers', 'regions', 'distributors', 'stores'));
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
            'description' => 'required|max:100',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $audit = new Audit;
        $audit->description = $request->description;
        $audit->start_date = date('Y-m-d',strtotime($request->start_date));
        $audit->end_date = date('Y-m-d',strtotime($request->end_date));
        $audit->save();

        Session::flash('flash_message', 'Audit successfully added!');

        return redirect()->route("audit.index");
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
