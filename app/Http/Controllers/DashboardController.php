<?php /** @noinspection DuplicatedCode */

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use JetBrains\PhpStorm\ArrayShape;
use mysql_xdevapi\Table;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response
    {
        $recent_orders = $this->get_orders();

        $topData = $this->get_top_data();

        $bar_chart_data = $this->barchart_data();


        return Inertia::render('Dashboard', [
            'order' => null,
            'recent_orders' => $recent_orders,
            'top_data' => $topData,
            'bar_chart_data' => $bar_chart_data
        ]);
    }

    public function get_orders(): \Illuminate\Support\Collection
    {
        return DB::table('orders')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }



    public function dashboard_search_order_by_id(Request $request): \Illuminate\Support\Collection
    {
        $id = $request['id'];

        if ($id != null) {
            return Order::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->get();
        } else {
            return $this->get_orders();
        }

    }

    public function dashboard_change_form_data(Request $request)
    {
        $id = $request['id'];

        $order = Order::find($request['id']);

        $order->push($order->procurements);

        return ($order);

    }

    #[ArrayShape(['orders_received' => "\Illuminate\Support\Collection", 'orders_fulfilled' => "\Illuminate\Support\Collection", 'orders_pending' => "\Illuminate\Support\Collection", 'issues' => "mixed"])] public function get_top_data(): array
    {
        $orders_received = DB::table('orders');

        if (Auth::user()->account_type == 'Sales') {
            $orders_received = $orders_received->where('user_id', Auth::user()->id)->get();
        } else {
            $orders_received = $orders_received->get();
        }

        $orders_fulfilled = DB::table('orders')
            ->where('delivery_status', 'Fulfilled');

        if (Auth::user()->account_type == 'Sales') {
            $orders_fulfilled = $orders_fulfilled->where('user_id', Auth::user()->id)->get();
        } else {
            $orders_fulfilled = $orders_fulfilled->get();
        }

        $orders_pending = DB::table('orders')
            ->where('delivery_status', '<>', 'Fulfilled');

        if (Auth::user()->account_type == 'Sales') {
            $orders_pending = $orders_pending->where('user_id', Auth::user()->id)->get();
        } else {
            $orders_pending = $orders_pending->get();
        }


        $proc = DB::table('procurements')
            ->select('order_id')
            ->where('status', 'Unfulfillable')
            ->orWhere('status', 'Partially Fulfillable');

        $orders_with_issues = DB::table('finances')
            ->select('order_id')
            ->where('status', 'Rejected')
            ->union($proc)->get();

        $orders_with_issues_array = [];

        $orders_with_issues->map(function ($item,$key) use (&$orders_with_issues_array){
            array_push($orders_with_issues_array, $item->order_id);
        });

        if (Auth::user()->account_type == 'Sales') {
            $issues = DB::table('orders')
                ->where('user_id', Auth::user()->id)
                ->whereIn('id',$orders_with_issues_array)->get();
        }else{
            $issues = DB::table('orders')->whereIn('id',$orders_with_issues_array)->get();
        }


        $issue_array = [];


        if (count($issues) > 0) {
            $issues->map(function ($item, $key) use (&$issue_array) {
                array_push($issue_array, $item->id);
            });
        }

        $collection = collect($issue_array);

        $issues = $collection->unique();

        return array(
            'orders_received' => $orders_received,
            'orders_fulfilled' => $orders_fulfilled,
            'orders_pending' => $orders_pending,
            'issues' => $issues,
        );
    }

    public function barchart_data()
    {
        $sales_by_date = DB::table('orders')->selectRaw('year(created_at) as year, month(created_at) as month,count(id) as records')
            ->whereRaw('year(curdate()) = year(created_at)')
            ->groupByRaw('year,month')->get();

        $sales_delivered = DB::select("SELECT year(delivers.estimated_time_of_arrival) as year,month(delivers.estimated_time_of_arrival) as month, COUNT(orders.id) as records
                                                from orders,delivers
                                                WHERE orders.id = delivers.order_id
                                                AND orders.delivery_status = 'Fulfilled'
                                                GROUP BY year,month;");


        $get_sales_received = function ($month, $year) use ($sales_by_date) {
            $entries = $sales_by_date->filter(function ($data) use ($month, $year) {
                return ($data->month == $month && $data->year == $year);
            })->first();

            return $entries ? $entries->records : 0;
        };

        $get_orders_delivered = function ($month, $year) use ($sales_delivered) {
            $entries = collect($sales_delivered)->filter(function ($data) use ($month, $year) {
                return ($data->month == $month && $data->year == $year);
            })->first();

            return $entries ? $entries->records : 0;
        };

        $data = [
            ['Months', 'Orders Received', 'Orders Delivered'],
            ['Jan', $get_sales_received(1, 2022), $get_orders_delivered(1, 2022)],
            ['Feb', $get_sales_received(2, 2022), $get_orders_delivered(2, 2022)],
            ['Mar', $get_sales_received(3, 2022), $get_orders_delivered(3, 2022)],
            ['Apr', $get_sales_received(4, 2022), $get_orders_delivered(4, 2022)],
            ['May', $get_sales_received(5, 2022), $get_orders_delivered(5, 2022)],
            ['Jun', $get_sales_received(6, 2022), $get_orders_delivered(6, 2022)],
            ['Jul', $get_sales_received(7, 2022), $get_orders_delivered(7, 2022)],
            ['Aug', $get_sales_received(8, 2022), $get_orders_delivered(8, 2022)],
            ['Sep', $get_sales_received(9, 2022), $get_orders_delivered(9, 2022)],
            ['Oct', $get_sales_received(10, 2022), $get_orders_delivered(10, 2022)],
            ['Nov', $get_sales_received(11, 2022), $get_orders_delivered(11, 2022)],
            ['Dec', $get_sales_received(12, 2022), $get_orders_delivered(12, 2022)],
        ];

        return $data;
    }
}
