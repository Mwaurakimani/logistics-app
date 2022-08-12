<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivers', function (Blueprint $table) {
            $table->id();
            $table->string ('handled_by')->nullable ();
            $table->string ('dispatched_from')->nullable ();
            $table->dateTime ('dispatch_date')->nullable ();
            $table->string ('region')->nullable ();
            $table->string ('transit_position')->nullable ();
            $table->string ('vehicle_id')->nullable ();
            $table->string ('estimated_time_of_arrival')->nullable ();
            $table->string ('comment')->nullable ();
            $table->unsignedBigInteger ('order_id');
            $table->timestamps();


            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivers');
    }
};
