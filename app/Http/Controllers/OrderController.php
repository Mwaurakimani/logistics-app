<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Models\Finance;
use App\Models\Order;
use App\Models\Procurement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function list_orders()
    {
        $orders = Order::latest()->paginate(15);



        $orders->getCollection()->transform(function ($item, $key) {

            $user_id = $item->user_id;

            $user = User::find($user_id);

            $item->user_id = $user->username;

            return $item;
        })->toArray();

        return Inertia::render('Dashboard/Orders/index', [
            'orders' => $orders,
        ]);
    }

    public function list_orders_with_filters(Request $request)
    {
        $search_id = $request['search_by_ID'];
        $date_created = $request['date_created'];
        $status = $request['status'];
        $apply_filters = $request['filters_applies'];

        $query = DB::table('orders');

        if ($apply_filters) {
            if ($search_id) {
                $query->where('id', $search_id);
            }

            if ($date_created) {
                $query->whereDate('created_at', $date_created);
            }

            if ($status != null || $status != '') {
                if ($status != 'All') {
                    $query->where('delivery_status', $status);
                }
            }
        }
//        dump($query->toSql());

        $orders = $query->paginate(15);

        $orders->getCollection()->transform(function ($item, $key) {

            $user_id = $item->user_id;

            $user = User::find($user_id);

            $item->user_id = $user->username;

            return $item;
        })->toArray();

        return Inertia::render('Dashboard/Orders/index', [
            'orders' => $orders,
        ]);
    }

    public function post_order(StoreOrder $request)
    {

        $order = new Order();

        $order->customer_name = $request['customer_name'];
        $order->contact_name = $request['contact_name'];
        $order->contact_phone = $request['contact_phone'];
        $order->contact_address = $request['contact_address'];
        $order->user_id = Auth::user()->id;
        $order->proposed_delivery_date = $request['proposed_delivery_date'];
        $order->comments = $request['comments'];
        $order->lpo_number = $request['lpo_number'];
        $order->lpo_value = $request['lpo_value'];
        $order->payment_status = $request['payment_status'];
        $order->delivery_status = $request['delivery_status'];

        $order->save();

        return Redirect::to('/orders');
    }

    public function edit_order(Order $Order)
    {
        $procurement = Procurement::where('order_id', $Order->id)->get();
        $finance = Finance::where('order_id', $Order->id)->get();

        return Inertia::render('Dashboard/Orders/orderForm', [
            'order' => $Order,
            'procurement' => $procurement,
            'finance' => $finance
        ]);
    }

    public function update_order(Order $Order, Request $request)
    {

        $Order->customer_name = $request['customer_name'];
        $Order->contact_name = $request['contact_name'];
        $Order->contact_phone = $request['contact_phone'];
        $Order->contact_address = $request['contact_address'];
        $Order->user_id = Auth::user()->id;
        $Order->proposed_delivery_date = $request['proposed_delivery_date'];
        $Order->comments = $request['comments'];
        $Order->lpo_number = $request['lpo_number'];
        $Order->lpo_value = $request['lpo_value'];
        $Order->payment_status = $request['payment_status'];
        $Order->delivery_status = $request['delivery_status'];

        $Order->save();

        ItemController::add_item($Order,$request['tb']);

        return Redirect::to('/orders');
    }
}
