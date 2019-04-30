<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRainfallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rainfalls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('station_id')->nullable();
            $table->string('locationName',20);
            $table->string('CITY',20);
            $table->foreign('CITY')->references('id')->on('states');
            $table->string('TOWN',20);
            $table->foreign('TOWN')->references('id')->on('districts');
            $table->dateTime('day');
            $table->time('time');
            $table->decimal('ELEV', 5, 2)->nullable();
            $table->decimal('RAIN', 5, 2)->nullable();
            $table->decimal('MIN_10', 5, 2)->nullable();
            $table->decimal('HOUR_3', 5, 2)->nullable();
            $table->decimal('HOUR_6', 5, 2)->nullable();
            $table->decimal('HOUR_12', 5, 2)->nullable();
            $table->decimal('HOUR_24', 5, 2)->nullable();
            $table->decimal('NOW', 5, 2)->nullable();
            $table->string('ATTRIBUTE',20);
            
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
        Schema::dropIfExists('rainfalls');
    }
}
