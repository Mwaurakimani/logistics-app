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


        return Inertia::render('Dashboard', [
            'order' => null,
            'recent_orders' => $recent_orders,
            'top_data' => $topData,
        ]);
    }

    public function get_orders(): \Illuminate\Support\Collection
    {
        return DB::table('orders')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function dashboard_search_order_by_id(Request $request): \Illuminate\Support\Collection
    {
        $id = $request['id'];

        if ($id != null) {
            return Order::where('id', $id)
                ->get();
        } else {
            return $this->get_orders();
        }

    }

    public function dashboard_change_form_data(Request $request)
    {
        $id = $request['id'];

        $order = Order::where('id', $request['id'])->get();

        return $order[0];
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
            ->where('status','Unfulfillable');

        $partials = DB::table('procurements')
            ->select('order_id')
            ->where('status','Partially Fulfillable');

        $issues = DB::table('orders')
            ->where('user_id',Auth::user()->id)
            ->whereIn('id',
                $proc = DB::table('finances')
                    ->select('order_id')
                    ->where('status','Rejected')
                    ->union($proc)
                    ->union($partials)
            )->get();

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
}
