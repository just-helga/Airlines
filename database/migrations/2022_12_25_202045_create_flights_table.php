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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_city_id');
            $table->unsignedBigInteger('to_city_id');
            $table->foreign('from_city_id')->references('id')->on('cities');
            $table->foreign('to_city_id')->references('id')->on('cities');
            $table->date('date_from');
            $table->time('time_from');
            $table->date('date_to');
            $table->time('time_to');
            $table->string('time_way');
            $table->float('percent_price');
            $table->unsignedBigInteger('air_id');
            $table->foreign('air_id')->references('id')->on('airs');
            $table->string('status')->default('новый');
            $table->unsignedBigInteger('from_airport_id');
            $table->unsignedBigInteger('to_airport_id');
            $table->foreign('from_airport_id')->references('id')->on('airports');
            $table->foreign('to_airport_id')->references('id')->on('airports');
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
        Schema::dropIfExists('flights');
    }
};
