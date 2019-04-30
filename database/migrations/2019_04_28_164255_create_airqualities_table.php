<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirqualitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airqualities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CITY',20);
            $table->foreign('CITY')->references('id')->on('states');
            $table->string('TOWN',20);
            $table->foreign('TOWN')->references('id')->on('districts');
            $table->decimal('Latitude', 10, 6)->nullable();
            $table->decimal('Longitude', 10, 6)->nullable();
            $table->integer('AQI')->nullable();
            $table->decimal('CO', 5, 2)->nullable();
            $table->decimal('CO_8hr', 5, 2)->nullable();
            $table->decimal('NO', 5, 2)->nullable();
            $table->decimal('NO2', 5, 2)->nullable();
            $table->decimal('NOx', 5, 2)->nullable();
            $table->decimal('O3', 5, 2)->nullable();
            $table->decimal('O3_8hr', 5, 2)->nullable();
            $table->decimal('PM10', 5, 2)->nullable();
            $table->decimal('PM10_AVG', 5, 2)->nullable();
            $table->decimal('PM2_5', 5, 2)->nullable();
            $table->decimal('PM2_5_AVG', 5, 2)->nullable();
            $table->string('Pollutant',20)->nullable();
            $table->string('status',20)->nullable();
            $table->dateTime('day');
            $table->time('time');
            $table->decimal('SO2', 5, 2)->nullable();
            $table->decimal('SO2_AVG', 5, 2)->nullable();
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
        Schema::dropIfExists('airqualities');
    }
}
