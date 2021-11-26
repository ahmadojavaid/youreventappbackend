<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_timings', function (Blueprint $table){
            $table->increments('id');
            $table->integer('session_id');
            $table->integer('hiring_id');
            $table->integer('user_id');
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->integer('status')->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('schedules_timings');
    }
}
