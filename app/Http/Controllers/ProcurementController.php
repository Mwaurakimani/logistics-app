<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProcurementController extends Controller
{
    public function uploading_procurement_details (Request $request, Order $Order)
    {
        $order_id = $Order->id;

        $procurement = Procurement::where ('order_id', $order_id)
                                  ->get ();

        if (count ($procurement) > 0) {
            $this->update_procurement ($procurement[0], $request, $order_id);
        }
        else {
            $this->create_procurement ($request, $order_id);
        }

        return Redirect::back ();
    }

    public function create_procurement ($request, $order_id)
    {
        $procurement = new Procurement();
        $file = $request->file ('opfFile');

        $procurement->order_id = $order_id;
        $procurement->status = $request['status'] ?? 'Pending';
        $procurement->comments = $request['comments'] ?? 'Pending';

        if ($file) {
            $procurement->opf_file_path = $this->uploading_opf ($file, $order_id);

        }
        $procurement->save ();

        return Redirect::back ();
    }

    public function update_procurement ($procurement, $request, $order_id)
    {
        $file = $request->file ('opfFile');


        $procurement->status = $request['status'] ?? $procurement->status;
        $procurement->comments = $request['comments'] ?? $procurement->comments;

        if ($file) {
            $procurement->opf_file_path = $this->uploading_opf ($file, $order_id);
        }
        $procurement->save ();

        Session::flash('sess_message',"Procurement Status was updated Successfully");

        return Redirect::back ();
    }

    public function uploading_opf ($file, $order_id)
    {

        $extension = $file->getClientOriginalExtension ();
        $name = 'opf_' . $order_id . '.' . $extension;

        $path = Storage::putFileAs ('public/opf', $file, $name);

        return $path;
    }

    public function download_opf (Request $request)
    {
        $file = Storage::path ($request['path']);

        return response ()->download ($file);
    }
}
