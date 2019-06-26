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
            $table->string('CO',20)->nullable();
            $table->string('CO_8hr',20)->nullable();
            $table->string('NO',20)->nullable();
            $table->string('NO2',20)->nullable();
            $table->string('NOx',20)->nullable();
            $table->string('O3',20)->nullable();
            $table->string('O3_8hr',20)->nullable();
            $table->string('PM10',20)->nullable();
            $table->string('PM10_AVG',20)->nullable();
            $table->string('PM2_5',20)->nullable();
            $table->string('PM2_5_AVG',20)->nullable();
            $table->string('Pollutant',20)->nullable();
            $table->string('status',20)->nullable();
            $table->dateTime('day')->nullable();
            $table->time('time')->nullable();
            $table->string('SO2',20)->nullable();
            $table->string('SO2_AVG',20)->nullable();
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
