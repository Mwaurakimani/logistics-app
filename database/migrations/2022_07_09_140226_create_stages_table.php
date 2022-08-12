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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('location');
            $table->string('items');
            $table->string('time');
            $table->string('date');
            $table->text('full_details')->nullable ();
            $table->unsignedBigInteger ('delivery_id');
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('delivers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stages');
    }
};
