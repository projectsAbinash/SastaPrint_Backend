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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->integer('available_papers');
            $table->integer('used_papers')->nullable();
            $table->timestamp('phone_verified_at')->nullable();    
            $table->string('password');
            
            $table->unsignedBigInteger('branch');
            $table->foreign('branch')->references('id')->on('branches');
            $table->rememberToken();       
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
        Schema::dropIfExists('employees');
    }
};
