<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrdersHellperController extends Controller
{
    public function filter_orders(Request $request)
    {
        $status = $request['status'];

        $query = Order::where('id', '>', 0);

        if ($status && $status != 'all') {
            $query->where('delivery_status', $status);
        }

        $orders = $query->get();

        return $orders;
    }

    public function filtered_orders(Request $request)
    {

        dd($request);
        $orders = Order::all();


        $orders = $orders->transform(function ($item, $key) {
            $user_id = $item->user_id;

            $user = User::find($user_id);

            $item->user_id = $user->username;

            return $item;
        });

        return Inertia::render('Dashboard/Orders/index', [
            'orders' => $orders,
        ]);
    }

    public function dashboard_ordersReceived()
    {
        $orders = Order::all();


        $orders = $orders->transform(function ($item, $key) {
            $user_id = $item->user_id;

            $user = User::find($user_id);

            $item->user_id = $user->username;

            return $item;
        });

        return Inertia::render('Dashboard/Orders/index', [
            'orders' => $orders
        ]);
    }

    public function dashboard_ordersFulfilled()
    {
        $status = 'Fulfilled';

        $query =  Order::with(['procurements','finance']);

        if ($status != 'All') {
            $query->where('delivery_status', $status);
        }

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

    public function dashboard_ordersPending()
    {
        $status = 'Fulfilled';

        $query =  Order::with(['procurements','finance']);

        $query->where('delivery_status', '<>', $status)->get();

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

    public function dashboard_issues()
    {
        //issues
        $issues_with_fullfilment = DB::table('procurements')
            ->where('status', 'Unfulfillable')
            ->get();
        $issues_with_partial_fullfilment = DB::table('procurements')
            ->where('status', 'Partially Fulfillable')
            ->get();
        $issues_with_finance_rejected = DB::table('finances')
            ->where('status', 'Rejected')
            ->get();

        $issues = [];

        if (count($issues_with_fullfilment) > 0) {
            $issues_with_fullfilment->map(function ($item, $key) use (&$issues) {
                array_push($issues, $item->order_id);
            });
        }

        if (count($issues_with_partial_fullfilment) > 0) {
            $issues_with_partial_fullfilment->map(function ($item, $key) use (&$issues) {
                array_push($issues, $item->order_id);
            });
        }

        if (count($issues_with_finance_rejected) > 0) {
            $issues_with_finance_rejected->map(function ($item, $key) use (&$issues) {
                array_push($issues, $item->order_id);
            });

        }

        $collection = collect($issues);

        $issues = $collection->unique();

        $orders =  Order::with(['procurements','finance'])->whereIn('id', $issues)->paginate(15);

        $orders->getCollection()->transform(function ($item, $key) {

            $user_id = $item->user_id;

            $user = User::find($user_id);

            $item->user_id = $user->username;

            return $item;
        })->toArray();

        return Inertia::render('Dashboard/Orders/index', [
            'orders' => $orders
        ]);
    }
}
