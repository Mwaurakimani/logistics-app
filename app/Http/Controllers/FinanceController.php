<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class FinanceController extends Controller
{
    public function update_finance_details (Request $request, Order $Order)
    {
        $order_id = $Order->id;

        $finance = Finance::where('order_id', $order_id)->get();

        if(count($finance) > 0){
            $this->update_finance($finance[0],$request,$order_id);
        }else{
            $this->create_finance($request, $order_id);
        }

        Session::flash('sess_message',"Finance details were updated Successfully");

        return Redirect::back ();
    }

    private function update_finance ($finance, $request, $order_id) {
        $finance->status = $request['status'];
        $finance->comment = $request['comments'];

        $finance->save();

        Session::flash('sess_message',"Finance details were updated Successfully");

        return Redirect::back ();
    }

    private function create_finance ($request, $order_id) {

        $finance = new Finance();

        $finance->order_id = $order_id;
        $finance->status = $request['status'];
        $finance->comment = $request['comments'];

        $finance->save ();

        return Redirect::back ();
    }
}
