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
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_address');
            $table->string('user_id');
            $table->date('date_received');
            $table->date('proposed_delivery_date');
            $table->string('comments');
            $table->string('lpo_number');
            $table->decimal('lpo_value',15,2);
            $table->string ('payment_status');
            $table->string ('delivery_status');
            $table->timestamps();
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