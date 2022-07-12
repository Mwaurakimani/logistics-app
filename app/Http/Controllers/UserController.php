<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    //list users
    public function index (): \Inertia\Response
    {
        $all_users = User::all();
        
        return Inertia::render ('Dashboard/Users/index',[
            'users' => $all_users
        ]);
    }
    
    //post user
    public function post_user (Request $request)
    {
        $user = new User();
        
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone =  $request['phone'];
        $user->password =  bcrypt ('password');
        $user->account_type =  $request['account_type'];
        $user->notes =  $request['notes'];
        
        $user->save();
    }
    
    public function get_user(User $user){
        return Inertia::render ('Dashboard/Users/userForm',[
            'selected_user' => $user
        ]);
    }
    
    public function update_user (User $user,Request $request)
    {
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone =  $request['phone'];
        $user->account_type =  $request['account_type'];
        $user->notes =  $request['notes'];
    
        $user->save();
    }
    
    public function update_user_password (User $user,Request $request)
    {
    
    }
}