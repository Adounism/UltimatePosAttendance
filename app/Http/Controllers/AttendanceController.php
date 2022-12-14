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
        $faceId = $request->request->get("faceId");

        $employeface = Employe::where("faceId", $faceId)->first();

 
   
        $macAddress = substr(exec('getmac'), 0, 17);
        $device = Device::where("macAddress", $macAddress)->first();
        // var_dump(json_decode($device));
        // dd();

        if ($device !== null) {
            if ($device->enabled) {
                 if($employeface !==null){
                    if(isset($faceId)){
                        // $employeface->attendance()->save($employeface);
                        $heure_arriver = date('d-m-y h:i:s');
                        $attendance = new Attendance([
                            'employe_id' => $employeface->id,
                            'heure_arriver' => $heure_arriver
                        ]);
                        $attendance->save();
                        return response()->json(['success' => true, 'msg'=>'Presence ajout?? avec succes'],201);                
                    }
                }else{
                    return response()->json(['success' => false, 'message'=>'utilisateur introuvale'], 404);
                }

            }else{
                return response()->json([
                    'success' => false,
                    'msg' => "L'appareil est desactiver veillez l'activer svp!!"
                ], 401);

            }

            // if(!isset($faceId) ){
            //     if($employeface->attendance()->save($attendance)){
            //         return response()->json(['msg'=>'attendance Saved','data'=>$attendance],200);
            //     }else{
            //         return response()->json(['msg'=>'Employer non Enregistrer','data'=>$faceId], 500);
            //     }
                 
            // }
        }else{

            return response()->json(['msg'=>'Device not valide','data'=>$faceId],500);

        }    

        


        // var_dump(json_decode($faceId));

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
