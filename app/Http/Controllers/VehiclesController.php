<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class VehiclesController extends Controller
{
    public function index (): \Inertia\Response
    {
        $vehicles = Vehicle::all();

        return Inertia::render ('Dashboard/Vehicles/index',[
            'vehicles' => $vehicles
        ]);
    }

    public function add_Vehicle (): \Inertia\Response
    {
        return Inertia::render ('Dashboard/Vehicles/addVehicles',[
            'vehicle' => null
        ]);
    }

    public function update_Vehicle (Request $request, Vehicle $Vehicle): \Inertia\Response
    {
        $drivers = User::where('account_type','Logistics')->get();
        $driver= User::where('id',$Vehicle->user_id)->get();

        if(count($driver)>0){
            $driver_set = $driver [0];
        }else{
            $driver_set = null;
        }

        return Inertia::render ('Dashboard/Vehicles/addVehicles',[
            'Vehicle' => $Vehicle,
            'Drivers' => $drivers,
            'driver_set' => $driver_set
        ]);
    }

    public function post_Vehicle (Request $request)
    {
        $vehicle = new Vehicle();

        $vehicle->registration_number = $request->reg_number;
        $vehicle->model = $request->model;
        $vehicle->class = $request->vehicle_class;
        $vehicle->notes = $request->notes;

        $vehicle->save();

        Session::flash('sess_message',"Vehicle was updated Successfully");

        return Redirect::to ('/vehicles');
    }

    public function put_Vehicle (Request $request, Vehicle $Vehicle)
    {
        $Vehicle->registration_number = $request->reg_number;
        $Vehicle->model = $request->model;
        $Vehicle->class = $request->vehicle_class;
        $Vehicle->user_id = $request->driver;
        $Vehicle->notes = $request->notes;

        $Vehicle->save();

        Session::flash('sess_message',"Vehicle was updated Successfully");

        return Redirect::back ();
    }
}
