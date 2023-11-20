<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('flight_number');
            $table->unsignedInteger('door');
            $table->bigInteger('origin_id')->unsigned();
            $table->bigInteger('destiny_id')->unsigned();
            $table->time('hour', $precision = 0);
            $table->string('seat');
            $table->unsignedInteger('weight');
            $table->unsignedInteger('quantity');
            $table->string('ticket');
            $table->unsignedInteger('total');
            $table->bigInteger('age_id')->unsigned();
            $table->bigInteger('passenger_id')->unsigned();
            $table->timestamps();

            //relation
            $table->foreign('age_id')->references('id')->on('ages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('passenger_id')->references('id')->on('passengers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
