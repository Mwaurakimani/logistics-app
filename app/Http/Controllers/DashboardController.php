<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use JetBrains\PhpStorm\ArrayShape;
use mysql_xdevapi\Table;

class DashboardController extends Controller
{
    public function index (): \Inertia\Response
    {
        $recent_orders = $this->get_orders ();
        
        $topData = $this->get_top_data ();
        
        
        return Inertia::render ('Dashboard', [
            'order' => null,
            'recent_orders' => $recent_orders,
            'top_data' => $topData,
        ]);
    }
    
    public function get_orders (): \Illuminate\Support\Collection
    {
        return DB::table ('orders')
                 ->orderBy ('created_at', 'desc')
                 ->take (5)
                 ->get ();
    }
    
    
    #[ArrayShape(['orders_received' => "\Illuminate\Support\Collection", 'orders_fulfilled' => "\Illuminate\Support\Collection", 'orders_pending' => "\Illuminate\Support\Collection", 'issues' => "mixed"])] public function get_top_data (): array
    {
        $orders_received = DB::table ('orders')
                             ->get ();
        $orders_fulfilled = DB::table ('orders')
                              ->where ('delivery_status', 'Fulfilled')
                              ->get ();
        $orders_pending = DB::table ('orders')
                            ->where ('delivery_status', '<>', 'Fulfilled')
                            ->get ();
        
        //issues
        $issues_with_fullfilment = DB::table ('procurements')
                                     ->where ('status', 'Unfulfillable')
                                     ->get ();
        $issues_with_partial_fullfilment = DB::table ('procurements')
                                             ->where ('status', 'Partially Fulfillable')
                                             ->get ();
        $issues_with_finance_rejected = DB::table ('finances')
                                          ->where ('status', 'Rejected')
                                          ->get ();
        
        $issues = [];
        
        if (count ($issues_with_fullfilment) > 0) {
            $issues_with_fullfilment->map (function ($item, $key) use (&$issues) {
                array_push ($issues, $item->order_id);
            });
        }
        
        if (count ($issues_with_partial_fullfilment) > 0) {
            $issues_with_partial_fullfilment->map (function ($item, $key) use (&$issues) {
                array_push ($issues, $item->order_id);
            });
        }
        
        if (count ($issues_with_finance_rejected) > 0) {
            $issues_with_finance_rejected->map (function ($item, $key) use (&$issues) {
                array_push ($issues, $item->order_id);
            });
            
        }
        
        $collection = collect ($issues);
        
        $issues = $collection->unique ();
        
        return array(
            'orders_received' => $orders_received,
            'orders_fulfilled' => $orders_fulfilled,
            'orders_pending' => $orders_pending,
            'issues' => $issues,
        );
    }
    
    
    public function dashboard_search_order_by_id (Request $request): \Illuminate\Support\Collection
    {
        $id = $request['id'];
        
        if ($id != null) {
            return Order::where ('id', $id)
                        ->get ();
        }else{
            return $this->get_orders ();
        }
        
    }
    
    public function dashboard_change_form_data (Request $request)
    {
        $id = $request['id'];
        
        $order = Order::where('id',$request['id'])->get();
        
        return $order[0];
    }
}