<?php

namespace App\Http\Controllers;
use App\Utils\ModuleUtil;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

use App\Attendance;
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
        $request->validate([
            'employe_id' =>'required',
            'heure_arriver' =>'required',
            'heure_deppart' => 'required',
        ]);

        $attendance = new Attendance([
            'employe_id' => $request->get('employe_id'),
            'heure_arriver' => $request->get('heure_arriver'),
            'heure_deppart' => $request->get('heure_deppart'),
        ]);

        $attendance->save();

        return response()->json($attendance);
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
        //
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
