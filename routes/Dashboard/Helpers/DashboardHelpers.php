<?php


use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::post ('/helper/dashboard_search_order_by_id', [DashboardController::class,'dashboard_search_order_by_id'])->name ('dashboard_search_order_by_id');

Route::post ('/helper/dashboard_change_form_data', [DashboardController::class,'dashboard_change_form_data'])->name ('dashboard_change_form');