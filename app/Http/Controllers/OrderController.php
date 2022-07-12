<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function list_orders ()
    {
        $orders = Order::all();
        
        $orders = $orders->transform (function($item,$key){
            $user_id = $item->user_id;
            
            $user = User::find($user_id);
            
            $item->user_id = $user->username;
            
            return $item;
        });
        
        return Inertia::render ('Dashboard/Orders/index',[
            'orders' => $orders
        ]);
    }
    
    public function post_order (Request $request)
    {
        $order = new Order();
        
        $order->customer_name = $request['customer_name'];
        $order->contact_name = $request['contact_name'];
        $order->contact_phone = $request['contact_phone'];
        $order->contact_address = $request['contact_address'];
        $order->user_id = $request['user_id'];
        $order->date_received = $request['date_received'];
        $order->proposed_delivery_date = $request['proposed_delivery_date'];
        $order->comments = $request['comments'];
        $order->lpo_number = $request['lpo_number'];
        $order->lpo_value = $request['lpo_value'];
        $order->payment_status = $request['payment_status'];
        $order->delivery_status = $request['delivery_status'];
        
        $order->save();
    }
    
    public function edit_order (Order $Order)
    {
        return Inertia::render ('Dashboard/Orders/orderForm',[
            'order' => $Order
        ]);
    }
    
    public function update_order (Order $Order, Request $request)
    {
        $Order->customer_name = $request['customer_name'];
        $Order->contact_name = $request['contact_name'];
        $Order->contact_phone = $request['contact_phone'];
        $Order->contact_address = $request['contact_address'];
        $Order->user_id = $request['user_id'];
        $Order->date_received = $request['date_received'];
        $Order->proposed_delivery_date = $request['proposed_delivery_date'];
        $Order->comments = $request['comments'];
        $Order->lpo_number = $request['lpo_number'];
        $Order->lpo_value = $request['lpo_value'];
        $Order->payment_status = $request['payment_status'];
        $Order->delivery_status = $request['delivery_status'];
        
        $Order->save();
    }
}