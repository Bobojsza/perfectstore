<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FormGroup;

class FormGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $formgroups = FormGroup::all();
        return view('formgroup.index', compact('formgroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('formgroup.create');
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
            'group_desc' => 'required|unique:form_groups|max:100',
        ]);

        \DB::beginTransaction();
        try {
            $group = new FormGroup;
            $group->group_desc = $request->group_desc;
            $group->secondary_display = ($request->secondary_display) ? 1 : 0;
            $group->osa = ($request->osa) ? 1 : 0;  
            $group->sos = ($request->sos) ? 1 : 0;    
            $group->custom = ($request->custom) ? 1 : 0;                     
            $group->save();

            \DB::commit();

            Session::flash('flash_message', 'Form Group successfully added!');
            return redirect()->route("formgroup.index");

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
        $formgroup = FormGroup::findOrFail($id);
        return view('formgroup.edit', compact('formgroup'));
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
        $group = FormGroup::findOrFail($id);

        $this->validate($request, [
            'group_desc' => 'required||max:100|unique_with:form_groups,'.$id
        ]);

        \DB::beginTransaction();
        try {
            $group->group_desc = strtoupper($request->group_desc);
            $group->secondary_display = ($request->secondary_display) ? 1 : 0;
            $group->osa = ($request->osa) ? 1 : 0;    
            $group->sos = ($request->sos) ? 1 : 0;  
            $group->custom = ($request->custom) ? 1 : 0;                              
            $group->update();
            \DB::commit();

            Session::flash('flash_message', 'Form Group successfully updated!');
            return redirect()->route("formgroup.edit",[$id]);
            
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
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
