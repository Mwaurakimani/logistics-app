<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        return Inertia::render ('Dashboard/Vehicles/addVehicles',[
            'Vehicle' => $Vehicle
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
        
        return Redirect::to ('/vehicles');
    }
    
    public function put_Vehicle (Request $request, Vehicle $Vehicle)
    {
        $Vehicle->registration_number = $request->reg_number;
        $Vehicle->model = $request->model;
        $Vehicle->class = $request->vehicle_class;
        $Vehicle->notes = $request->notes;
    
        $Vehicle->save();
    
        return Redirect::back ();
    }
}