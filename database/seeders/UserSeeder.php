<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        
        $user->username = 'mwaura';
        $user->email = 'mwaura@email.com';
        $user->password = bcrypt ('password');
        $user->phone =  '+254 700 000 000';
        $user->account_type =  'Admin';
        
        $user->save();
    }
}