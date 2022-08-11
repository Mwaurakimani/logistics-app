<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Couchbase\User;
use Illuminate\Support\Facades\Route;

Route::post ('/helper/get_user', [UserController::class,'SearchUser'])->name ('dashboard_search_user');

Route::get ('/helper/get_user', [UserController::class,'index'])->name ('dashboard_search_user');

