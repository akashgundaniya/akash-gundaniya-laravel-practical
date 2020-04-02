<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendships', function (Blueprint $table) { 
            $table->bigIncrements('id');
              $table->bigInteger('first_user')->index();
              $table->bigInteger('second_user')->index();
              $table->bigInteger('acted_user')->index();
              $table->enum('status', ['pending', 'confirmed', 'blocked'])->default('pending');
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
        Schema::dropIfExists('friendships');
    }
}
