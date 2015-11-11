<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\GradeMatrix;

class GradeMatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $matrixs = GradeMatrix::all();
        return view('gradematrix.index',compact('matrixs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('gradematrix.create');
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
            'desc' => 'required|max:100|unique_with:grade_matrixs, passing = passing',
            'passing' => 'required|not_in:0'
        ]);

        \DB::beginTransaction();

        try {
            $matrix = new GradeMatrix;
            $matrix->desc = $request->desc;
            $matrix->passing = $request->passing;
            $matrix->save();

            \DB::commit();

            Session::flash('flash_message', 'Grade matrix successfully added!');
            return redirect()->route("gradematrix.index");

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
        $matrix = GradeMatrix::findOrFail($id);
        return view('gradematrix.edit',compact('matrix'));
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
        $matrix = GradeMatrix::findOrFail($id);

        $this->validate($request, [
            'desc' => 'required|max:100|unique_with:grade_matrixs, passing = passing,'.$id,
            'passing' => 'required|not_in:0'
        ]);

        \DB::beginTransaction();
        try {
            $matrix->desc = $request->desc;
            $matrix->passing = $request->passing;                          
            $matrix->update();
            \DB::commit();

            Session::flash('flash_message', 'Grade Matrix successfully updated!');
            return redirect()->route("gradematrix.edit",[$id]);
            
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
