<?php

use App\Http\Controllers\DeliverController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\UserController;
use App\Models\Deliver;
use App\Models\Stage;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware (['auth:sanctum', config ('jetstream.auth_session'), 'verified',])
     ->group (function () {
         
         //Dashboard
         Route::get ('/dashboard', function () {
             return Inertia::render ('Dashboard');
         })->name ('dashboard');
         
         
         
         
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
             
             $stages = null;
             
             if(count($delivery) > 0){
                 $stages = Stage::where('delivery_id',$delivery[0]->id)->get();
             }
             
             return Inertia::render ('Dashboard/Orders/deliveryDetails',[
                 'delivery' => $delivery,
                 'order' => $Order,
                 'stages' => $stages
             ]);
         })->name ('dashboard_orders_delivery_Details');
         
         Route::post ('/order/{Order}/deliveryDetails',[DeliverController::class,'generate_order'])->name ('generate_order');
         
         Route::put ('/order/{Order}/deliveryDetails/{Delivery}',[DeliverController::class,'update_delivery'])->name ('update_delivery');
         
         Route::put ('/order/{Order}/deliveryDetails/{Delivery}',[DeliverController::class,'update_delivery'])->name ('update_delivery');
         
         
         
         //stage
         Route::post ('/stage/{Delivery}',[StageController::class,'create_stage'])->name ('create_stage');
         
         
         
         
         
         //Order
         //display the orders list
         Route::get('/orders/create', function () {
             return Inertia::render ('Dashboard/Orders/orderForm',[
                 'order' => null
             ]);
         })->name ('dashboard_add_order');
    
         //display the list of orders
         Route::get('/orders', [OrderController::class,'list_orders'])->name ('dashboard_orders');
    
         //display the selected orders
         Route::get('/orders/{Order}', [OrderController::class,'edit_order'])->name ('dashboard_select_order');
    
         //display the list of orders
         Route::post('/orders/create', [OrderController::class,'post_order'])->name ('post_order');
    
         //display the list of orders
         Route::post('/orders/{Order}', [OrderController::class,'update_order'])->name ('put_order');
         
         
         
         
         //Setting
         Route::get('/settings', function () {
             return Inertia::render ('Dashboard/Settings/index');
         })->name ('dashboard_settings');
         
         
     });