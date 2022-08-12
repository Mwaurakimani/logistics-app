<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStage;
use App\Models\Deliver;
use App\Models\Order;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StageController extends Controller
{
    public function create_stage (CreateStage $request, Deliver $Delivery)
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

        Session::flash('sess_message',"Progress was updated Successfully");
        return Redirect::back ();
    }

    public function delete_stage (Stage $Stage)
    {
        $Stage->delete ();
    }
}
