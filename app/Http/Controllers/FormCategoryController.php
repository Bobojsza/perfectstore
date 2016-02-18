<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FormCategory;

class FormCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $formcategories = FormCategory::all();
        return view('formcategory.index', compact('formcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('formcategory.create');
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
            'category' => 'required|unique:form_categories|max:100',
        ]);

        $category = new FormCategory;
        $category->category = $request->category;
        $category->secondary_display = ($request->secondary_display) ? 1 : 0;
        $category->osa_tagging = ($request->osa_tagging) ? 1 : 0;
        $category->sos_tagging = ($request->sos_tagging) ? 1 : 0;
        $category->custom = ($request->custom) ? 1 : 0;
        $category->perfect_store = ($request->perfect_store) ? 1 : 0;
        $category->save();

        Session::flash('flash_message', 'Form Category successfully added!');

        return redirect()->route("formcategory.index");
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
        $category = FormCategory::findOrFail($id);
        return view('formcategory.edit', compact('category'));
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
        $category = FormCategory::findOrFail($id);

        $this->validate($request, [
            'category' => 'required|max:100|unique_with:form_categories,'.$id
        ]);

        \DB::beginTransaction();
        try {
            $category->category = $request->category;
            $category->secondary_display = ($request->secondary_display) ? 1 : 0;
            $category->osa_tagging = ($request->osa_tagging) ? 1 : 0;
            $category->sos_tagging = ($request->sos_tagging) ? 1 : 0;    
            $category->custom = ($request->custom) ? 1 : 0;
            $category->perfect_store = ($request->perfect_store) ? 1 : 0;                      
            $category->update();
            \DB::commit();

            Session::flash('flash_message', 'Form Catagory successfully updated!');
            return redirect()->route("formcategory.edit",[$id]);
            
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
