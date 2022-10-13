<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{

  /**
     * Afficher la liste des appareils authentifiées
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = \App\Device::all();
        if (request()->ajax()) {
            return DataTables::of($devices)
                ->addColumn('action', function ($row) {
                    $state = $row->enabled ? ['Désactiver','danger'] : ['Activer','success'];
                    $action = '';
                    if (auth()->user()->can('user.view')) {
                        $action .= '<a href="' . action('DeviceController@toggle', [$row->id]) . '" class="btn btn-xs btn-'.$state[1].'"><i class="glyphicon glyphicon-edit"></i> ' .$state[0] . '</a>';

                        $action .= '&nbsp
                    <button data-href="' . action('DeviceController@delete', [$row->id]) . '" class="btn btn-xs btn-danger delete_device_button"><i class="glyphicon glyphicon-trash"></i> ' . __("messages.delete") . '</button>';
                    }
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
        return view('device.index', compact('devices'));
    }

    public function ping(Request $request)
    {

        if(!$request->isMethod(Request::METHOD_POST)){
            $output = [
                    'success' => false,
                    'msg' => "Méthode non authorisé"
            ];
            return redirect()->route("device.index")->with('status', $output);
        }
        $platform = request()->headers->get('user-agent', null);

        if ($platform === null) {
            return response()->json([
                'success' => false,
                'msg' => 'Platforme invalide .'
            ], 403);
        }
        $macAddress = substr(exec('getmac'), 0, 17);
        $existAdresse = Device::where("macAddress", $macAddress)->first();
        if ($existAdresse !== null) {
            if ($existAdresse->enabled) {
                return response()->json([
                   'success' => true,
                   'msg' => "Vous êtes authentifiés"
                ], 200);
            }
            return response()->json([
                'success' => false,
                'msg' => 'Votre requête est en cours de traitement'
            ], 200);
        }
        $adresse = new Device();
        $adresse->macAddress = $macAddress;
        $adresse->platform = $platform;
        $adresse->save();
        return response()->json([
            'success' => true,
            'msg' => 'Votre requête est en cours de traitement'
        ], 201);
    }
    function delete($id)
    {
        if (!auth()->user()->can('user.view')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {
                $device = Device::where('id', $id)->first();
                $device->delete();
                $output = [
                    'success' => true,
                    'msg' => "Appareil supprimée avec success"
                ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

                $output = [
                    'success' => false,
                    'msg' => __("messages.something_went_wrong")
                ];
            }
            return $output;
        }
    }
    function toggle($id)
    {
        if (!auth()->user()->can('user.view')) {
            return view('device.index');
        }
        $device = Device::where('id', $id)->first();
        if (null === $device) {
            return redirect()->route('device.index');
        }
        $device->enabled = !$device->enabled;
        $device->save();
        $output = [
            'success' => 1,
            'msg' => "Etat de l'appareil modifié avec succès"
        ];
        if (request()->ajax()) {
            $output = [
                'success' => true,
                'msg' => "Appareil supprimée avec success"
            ];
            return $output;
        }
        return redirect()->route('device.index')->with('status', $output);
    }
}
