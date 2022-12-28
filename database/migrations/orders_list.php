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
        Schema::create('order_data', function (Blueprint $table) {
            
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('order_id');

            $table->string('assigned_store')->nullable();
            $table->string('traking_link')->nullable();
            $table->string('delivery_charge');
            $table->string('amount');
            $table->string('address_id')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('order_data');
    }
};