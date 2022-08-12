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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('contact_name')->nullable ();
            $table->string('contact_phone')->nullable ();
            $table->string('contact_address');
            $table->unsignedBigInteger('user_id');
            $table->date('proposed_delivery_date')->nullable ();
            $table->string('comments')->nullable ();
            $table->string('lpo_number');
            $table->decimal('lpo_value',15,2);
            $table->string ('payment_status');
            $table->string ('delivery_status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
