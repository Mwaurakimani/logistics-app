<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliverController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use App\Models\Deliver;
use App\Models\Stage;
use App\Models\Vehicle;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware (['auth:sanctum', config ('jetstream.auth_session'), 'verified',])
     ->group (function () {

         //Dashboard
         Route::get ('/dashboard', [DashboardController::class,'index'])->name ('dashboard');


         //User
         //display the list of users
         Route::get('/users',[UserController::class,'index'])->name ('dashboard_users');

         //display the user form
         Route::get('/users/create', function () {
             return Inertia::render ('Dashboard/Users/userForm',[
                 'user'=>null
             ]);
         })->name ('dashboard_add_users');

         //display the user form
         Route::get('/users/{user}', [UserController::class,'get_user'])->name ('dashboard_get_user');

         //save new user
         Route::post('/users/create',[UserController::class,'post_user'])->name ('post_new_user');

         //update user
         Route::post('/users/update/{user}',[UserController::class,'update_user'])->name ('update_user');

         //update user password
         Route::post('/users/updatePassword/{user}',[UserController::class,'update_user_password'])->name ('update_password');


         //deliveries
         //deliveries
         Route::get('/orders/{Order}/deliveryDetails', function ($Order) {
             $delivery = Deliver::where('order_id',$Order)->get();

             $vehicles = Vehicle::all ();

             $stages = null;

             if(count($delivery) > 0){
                 $stages = Stage::where('delivery_id',$delivery[0]->id)->get();
             }

             return Inertia::render ('Dashboard/Orders/deliveryDetails',[
                 'Vehicles' => $vehicles,
                 'delivery' => $delivery,
                 'order' => $Order,
                 'stages' => $stages
             ]);
         })->name ('dashboard_orders_delivery_Details');

         Route::post ('/order/{Order}/deliveryDetails',[DeliverController::class,'generate_order'])->name ('generate_order');

         Route::put ('/order/{Order}/deliveryDetails/{Delivery}',[DeliverController::class,'update_delivery'])->name ('update_delivery');


         //stage
         Route::post ('/stage/{Delivery}',[StageController::class,'create_stage'])->name ('create_stage');

         Route::delete ('/stage/{Stage}',[StageController::class,'delete_stage'])->name ('delete_stage');





         //Order

         //download opf
         Route::post ('/order/procurementDetails/download',[ProcurementController::class,'download_opf'])->name ('download_opf');

         //update procurement details
         Route::post ('/order/procurementDetails/{Order}',[ProcurementController::class,'uploading_procurement_details'])->name ('uploading_procurement_details');

         //finance details
         Route::post ('/order/financialDetails/{Order}',[FinanceController::class,'update_finance_details'])->name ('update_finance_details');

         //display the orders list
         Route::get('/orders/create', function () {
             return Inertia::render ('Dashboard/Orders/orderForm',[
                 'order' => null
             ]);
         })->name ('dashboard_add_order');

         //display the list of orders
         Route::get('/orders', [OrderController::class,'list_orders'])->name ('dashboard_orders');

         Route::post('/orders', [OrderController::class,'list_orders_with_filters'])->name ('dashboard_orders_with_filters');

         //display the selected orders
         Route::get('/orders/{Order}', [OrderController::class,'edit_order'])->name ('dashboard_select_order');

         //display the list of orders
         Route::post('/orders/create', [OrderController::class,'post_order'])->name ('post_order');

         //display the list of orders
         Route::post('/orders/{Order}', [OrderController::class,'update_order'])->name ('put_order');


         //vehicles
         Route::get ('/vehicles', [VehiclesController::class,'index'])->name ('dashboard_vehicles');
         Route::get ('/AddVehicle', [VehiclesController::class,'add_Vehicle'])->name ('dashboard_add_vehicle');
         Route::get ('/UpdateVehicle/{Vehicle}', [VehiclesController::class,'update_Vehicle'])->name ('dashboard_update_vehicle');
         Route::post ('/AddVehicle', [VehiclesController::class,'post_Vehicle'])->name ('post_vehicle');
         Route::put ('/PutVehicle/{Vehicle}', [VehiclesController::class,'put_Vehicle'])->name ('put_vehicle');





         //Setting
         Route::get('/settings', function () {
             return Inertia::render ('Dashboard/Settings/index');
         })->name ('dashboard_settings');

         require_once 'Helpers/DashboardHelpers.php';
         require_once 'Helpers/OrderHelpers.php';
         require_once 'Helpers/UserHelpers.php';

     });
