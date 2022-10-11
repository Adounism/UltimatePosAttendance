<?php

namespace App\Http\Controllers;

use App\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employe = Employe::all();

        if (request()->ajax()) {
      
            return response()->json($employe);
        }

        return view('attendance.employe')->with(compact('employe'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    

        $request->validate([
            'name' =>'required',
            'faceId' =>'required',
            'password' => 'required',
        ]);

        $employe = new Employe([
            'name' => $request->get('name'),
            'faceId' => $request->get('faceId'),
            'password' => $request->get('password'),
        ]);

        $employe->save();

        return response()->json($employe);
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
        $employe = Employe::findOrFail($id);

        $request->validate([
          'name' => 'required',
          'faceId' => 'required'
        ]);
      
        $employe->name = $request->get('name');
        $employe->text = $request->get('faceId');
      
        $employe->save();
      
        return response()->json($employe);
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
