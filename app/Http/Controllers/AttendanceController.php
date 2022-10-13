<?php

namespace App\Http\Controllers;
use App\Utils\ModuleUtil;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

use App\Attendance;
use App\Device;
use App\Employe;
use Exception;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function __construct(ModuleUtil $moduleUtil){
        $this->moduleUtil = $moduleUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $user_id = request()->session()->get('user.id');
        $attendances = Attendance::all();

        // if (!auth()->user()->can('user.view') && !auth()->user()->can('user.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $attendance = Attendance::all();
        // dd($attendance);

        if (request()->ajax()) {
      
            return response()->json($attendance);
        }

        return view('attendance.index')->with(compact('attendance'));

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
        $faceId = $request->faceId;

        $employeface = Employe::where('faceId', $faceId)->first();
        $attendance = new Attendance([
            'heure_arriver' => $request->get('heure_arriver'),
        ]);
        $macAddress = substr(exec('getmac'), 0, 17);
        $device = Device::where("macAdress", $macAddress)->first();
        var_dump(json_decode($device));
        dd();
        if ($device !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Votre requête est en cours de traitement'
            ], 200);


            if(!isset($faceId) ){
                if($employeface->attendance()->save($attendance)){
                    return response()->json(['message'=>'attendance Saved','data'=>$attendance],200);
                }else{
                    return response()->json(['message'=>'Employer non Enregistrer','data'=>$faceId], 500);
                }
                
                
            }
        }

        


        var_dump(json_decode($faceId));
        return response()->json(['message'=>'Employer Face Id non valide','data'=>$faceId],500);


        // $attendance->save();

        // return response()->json($attendance);
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
        $data = new Attendance([
            'heure_arriver' => $request->get('heure_arriver'),
        ]);
        
        //$attendance = Attendance::where('id', $id)->update($data, $id);
        // if(!$attendance ===null){

        //     if($attendance->attendance()->save($attendance)){
        //         return response()->json(['message'=>'attendance Saved','data'=>$attendance], 200);
        //     }
        // }

        try {
            $attendance = Attendance::findOrFail($id);
            // $data = Attendance::where('id', $id)->update($data, $id);
            var_dump(json_decode($attendance));


            if (is_null($attendance))
                return $this->responseError(null, 'Attendance Not Found', 402);

            return $this->responseSuccess($data, 'Attendance Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $attendance = Attendance::findOrFail($id);
        var_dump(json_decode($attendance));
        
        try {
    
            if (empty($attendance)) {
                return $this->responseError(null, 'Product Not Found', 402);
            }

           
            if (!$attendance) {
                return $this->responseError(null, 'Failed to delete the attendance.', 500);
            }

            return $this->responseSuccess($attendance, 'Attendance Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), 500);
        }
    }

}
