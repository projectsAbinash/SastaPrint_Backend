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
        Schema::create('documents_data', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('order_id');
            $table->string('doc_name');
            $table->string('total_pages');
            $table->string('title')->nullable();
            $table->string('instructions')->nullable();
            $table->string('copies_count')->nullable();
            $table->string('print_config')->nullable();
            $table->string('page_config')->nullable();
            $table->string('binding_config')->nullable();
            $table->string('path');
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
        Schema::dropIfExists('documents_data');
    }
};