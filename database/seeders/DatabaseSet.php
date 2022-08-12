<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSet extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->add_users();

        $this->add_orders();

        $this->add_vehicles();
    }

    public function add_users(){
        $user_data = json_decode(file_get_contents(storage_path('TempData/users.json')));

        $users = collect($user_data);
        $users->map(function ($user){
            $user->password = bcrypt("password");

            $user = new User((array) $user);

            $user->save();

        });

    }


    public function add_orders()
    {
        $file = fopen(storage_path('databseScratch/orders_databse.csv'),"r");

        $order_data = array();

        if($file !==false){
            while(($data = fgetcsv($file, 1000, ',')) !== false){
                $order = new Order();
//                array_push($order_data, $data);

                $order->customer_name = $data[2];
                $order->contact_name = $data[3];
                $order->contact_phone = $data[4];
                $order->contact_address = $data[5];
                $order->user_id = $data[6];
                $order->proposed_delivery_date = $data[7];
                $order->comments = $data[8];
                $order->lpo_number = $data[9];
                $order->lpo_value = $data[10];
                $order->payment_status = $data[11];
                $order->delivery_status = $data[12];
                $order->created_at = $data[13];
                $order->updated_at = $data[14];

                $order->save();
            }
        }
    }

    public function add_vehicles()
    {
        $vehicle_data = json_decode(file_get_contents(storage_path('TempData/vehicles.json')));

        $vehicles = collect($vehicle_data);
        $vehicles->map(function ($vehicle){
            $vh = new Vehicle((array) $vehicle);

            $vh->save();

        });
    }
}















