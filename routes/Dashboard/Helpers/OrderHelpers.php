<?php


use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersHellperController;
use Illuminate\Support\Facades\Route;

Route::post ('/order/filters', [OrdersHellperController::class,'filter_orders'])->name ('filter_orders');

Route::post ('/order/filteredPage', [OrdersHellperController::class,'filtered_orders'])->name ('filtered_orders');




Route::match(['get','post'],'/order/filteredPage/ordersReceived',[OrderController::class,'list_orders'] ) ->name ('dashboard_ordersReceived');
Route::match(['get','post'],'/order/filteredPage/ordersFulfilled',[OrdersHellperController::class,'dashboard_ordersFulfilled'] ) ->name ('dashboard_ordersFulfilled');
Route::match(['get','post'],'/order/filteredPage/ordersPending',[OrdersHellperController::class,'dashboard_ordersPending'] ) ->name ('dashboard_ordersPending');
Route::match(['get','post'],'/order/filteredPage/issues',[OrdersHellperController::class,'dashboard_issues'] ) ->name ('dashboard_issues');
