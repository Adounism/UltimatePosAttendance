<?php

namespace App\Http\Controllers;

use App\Employe;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $employe = Employe::all();

     
        // if (request()->ajax()) {
      
        //     return response()->json($employe);
        // }

        //  return view('attendance.employe')->with(compact('employe'));

         $employe = \App\Employe::all();
         if (request()->ajax()) {
             return DataTables::of($employe)
                 ->addColumn('action', function ($row) {
                     $state = $row->enabled ? ['Désactiver','danger'] : ['Activer','success'];
                     $action = '';
                    //  if (auth()->user()->can('user.view')) {
                    //      $action .= '<a href="' . action('DeviceController@toggle', [$row->id]) . '" class="btn btn-xs btn-'.$state[1].'"><i class="glyphicon glyphicon-edit"></i> ' .$state[0] . '</a>';
 
                    //      $action .= '&nbsp
                    //  <button data-href="' . action('DeviceController@delete', [$row->id]) . '" class="btn btn-xs btn-danger delete_device_button"><i class="glyphicon glyphicon-trash"></i> ' . __("messages.delete") . '</button>';
                    //  }
                     return $action;
                 })
                 ->editColumn('enabled', function ($row) {
                     if ($row->enabled) {
                         return '<span class="badge badge-success">Active</span>';
                     }
                     return '<span class="badge badge-danger">Inactive</span>';
                 })
                 ->removeColumn('id')
                 ->removeColumn('updated_at')
                 ->rawColumns([2, 4])
                 ->make(false);
         }
         return view('attendance.employe', compact('employe'));

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
    
        if($employe !== null){

            $employe->save();
    
            return response()->json([
                'success' => $employe->id,
                'msg' => "Employée ajouté avec succes"
             ], 201);
        }else{
            return response()->json([
                'success' => false,
                'msg' => "employe donne invalide"
             ], 400);

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
            if($faceId !==null){
                $employe->faceId = $faceId;
                $employe->save();
    
                return response()->json(['msg'=>'Visage ajouté avec succes '],200);
            }else{

                return response()->json(['msg'=>'Visage introuvable'],404);
            }
        }else{
            return response()->json(['msg'=>'Employe non existant'], 404);
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
