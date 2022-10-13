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
    
        // $employe = new Employe();
        // $employe->firstName = $request->input('firstName');
        // $employe->lastName = $request->input('lastName');
        // $employe->contact = $request->input('contact');

        $employe = new Employe([
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'contact' => $request->get('contact'),
            'faceId' => $request->get('faceId')
        ]);
    
        $employe->save();

        return response()->json([
            'success' => $employe->id,
            'msg' => "Vous êtes enregistrer avec succes"
         ], 201);
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
        //$employe = Employe::findOrFail($id);
        $employe = Employe::where('id', $id)->first();
        if($employe !==null){
            $faceId = $request->request->get("faceId");
            $employe->faceId = $faceId;
            $employe->save();

            return response()->json(['msg'=>'Employe update  succes','data'=>$faceId],200);
        }else{
            return response()->json(['msg'=>'Employe non existant'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employe $employe)
    {
    
        $employe->delete();

        return response()->json(['msg'=>'employe deleted successfull','data'=>$employe],200);
    }
}
