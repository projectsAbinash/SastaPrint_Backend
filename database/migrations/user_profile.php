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
        Schema::create('users_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('pic')->nullable();
            $table->string('gender')->nullable();  
            $table->string('dob')->nullable(); 
            $table->integer('student')->nullable(); 
            $table->string('occupation')->nullable(); 
            $table->string('Collage_Name')->nullable(); 
            $table->string('Course')->nullable(); 
            $table->string('Year')->nullable(); 
            $table->string('Semester')->nullable(); 
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
        Schema::dropIfExists('users_profiles');
    }
};