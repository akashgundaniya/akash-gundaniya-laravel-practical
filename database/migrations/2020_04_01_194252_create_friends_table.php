<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('send_by');
            $table->unsignedBigInteger('send_to'); 
            $table->tinyInteger('status')->default(0);   
            $table->timestamps(); 

            $table->foreign('send_by')
             ->references('id')->on('users')
             ->onDelete('cascade');

            $table->foreign('send_to')
             ->references('id')->on('users')
             ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friends');
    }
}
