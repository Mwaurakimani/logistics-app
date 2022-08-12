<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDeliver;
use App\Models\Deliver;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DeliverController extends Controller
{
    public function generate_order (Order $Order): \Illuminate\Http\RedirectResponse
    {
        $delivery_test = Deliver::where ('order_id', $Order['id'])
                                ->get ();

        if (count ($delivery_test) == 0) {
            $delivery = new Deliver();

            $delivery->order_id = $Order->id;

            $delivery->save ();
        }

        return Redirect::back ();
    }

    public function update_delivery (Order $Order, Deliver $Delivery, UpdateDeliver $request)
    {
        $Delivery->handled_by = $request['handled_by'];
        $Delivery->dispatched_from = $request['dispatched_from'];
        $Delivery->dispatch_date = $request['dispatch_date'];
        $Delivery->region = $request['region'];
        $Delivery->transit_position = $request['transit_position'];
        $Delivery->vehicle_id = $request['vehicle'];
        $Delivery->estimated_time_of_arrival = $request['estimated_time_of_arrival'];

        $Delivery->save();

        Session::flash('sess_message',"Delivery was updated Successfully");

        return Redirect::back ();
    }
}
