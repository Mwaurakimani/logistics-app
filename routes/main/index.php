<?php

use App\Models\Deliver;
use App\Models\Stage;
use Doctrine\Inflector\Rules\Turkish\Rules;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post ('/trackbyid', function (Request $request) {
    $id = $request['id'];

    $stages = null;
    $dates = null;
    $deliveries = null;

    $delivery = Deliver::where ('id', $id)
                       ->get ();

    if (count ($delivery) > 0) {
        $deliveries = $delivery;
        $stages = Stage::where ('delivery_id', $delivery[0]->id)
                       ->get ();

        if (count ($stages)) {
            $dates = [];

            //get used dates
            $stages->each (function ($item, $key) use (&$dates) {
                array_push ($dates, $item->date);
            });

            //remove all duplicates
            $dates = array_unique ($dates);

            foreach ($dates as $key1 => $date) {
                $dates[$key1] = array(
                    'date' => $date,
                    'date_items' => array(),
                );
                $stages->each (function ($item1, $key2) use (&$dates, $key1, $date) {
                    if ($item1->date == $date) {
                        array_push ($dates[$key1]['date_items'], $item1);
                    }
                });
            }

        }
    }


    return Inertia::render ('main/OrderDetails', [
        'delivery' => $deliveries,
        'stages' => $dates,
        'delivery_id' => $id,
    ]);
})
     ->name ('track_delivery_by_id');

Route::post('/postComment/{Delivery}',function (Request $request,Deliver $Delivery){
    if($request['comment'] != null && $request['comment'] != ''){
        $Delivery->comment = $request['comment'];

        $Delivery->save();
    };

    return redirect('/');
})->name('post_comment');
