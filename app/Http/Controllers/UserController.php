<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsers;
use App\Http\Requests\UpdateUsers;
use App\Http\Requests\UserPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
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
    public function post_user (StoreUsers $request)
    {
        $user = new User();

        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone =  $request['phone'];
        $user->password =  bcrypt ('password');
        $user->account_type =  $request['account_type'] ?? 'none' ;
        $user->notes =  $request['notes'];

        $user->save();

        Session::flash('sess_message',"User was created Successfully");

        return Redirect::to('/users');
    }

    public function get_user(User $user){
        return Inertia::render ('Dashboard/Users/userForm',[
            'selected_user' => $user
        ]);
    }

    public function update_user (User $user,UpdateUsers $request)
    {
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone =  $request['phone'];
        $user->account_type =  $request['account_type'];
        $user->notes =  $request['notes'];

        $user->save();

        Session::flash('sess_message',"User was updated Successfully");

        return Redirect::to('/users');
    }

    public function update_user_password (User $user,UserPasswordRequest $request)
    {
        $user->password = bcrypt ($request->new_password);

        $user->save ();

        Session::flash('sess_message',"Password was updated Successfully");

        return Redirect::back ();
    }

    public function SearchUser(Request $request)
    {
        $data = $request['data'];

        $user = User::where('username','LIKE',"%{$data}%")->get();

        return Inertia::render ('Dashboard/Users/index',[
            'users' => $user
        ]);
    }
}
