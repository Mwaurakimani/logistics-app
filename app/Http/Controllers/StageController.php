<?php

namespace App\Http\Controllers;

use App\Models\Deliver;
use App\Models\Order;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StageController extends Controller
{
    public function create_stage (Request $request, Deliver $Delivery)
    {
        $stage = new Stage();
        
        $stage->description = $request['description'];
        $stage->location = $request['location'];
        $stage->items = $request['items'];
        $stage->time = $request['time'];
        $stage->date = $request['date'];
        $stage->delivery_id = $Delivery->id;
        $stage->full_details = $request['full_details'];
        
        $stage->save();
        
        return Redirect::back ();
    }
}