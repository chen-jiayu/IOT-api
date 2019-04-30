<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnviromentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enviroments', function (Blueprint $table) {
            //$table->increments('id');
            $table->string('state_id',20);
            $table->foreign('state_id')->references('id')->on('states');
            $table->string('district_id',20);
            $table->foreign('district_id')->references('id')->on('districts');
            $table->dateTime('day');
            $table->time('time');
            $table->decimal('temperature', 5, 2)->nullable();
            $table->string('wind_direction', 4)->nullable();
            $table->decimal('wind_speed', 5, 2)->nullable();
            $table->string('wind_scale',20)->nullable();;          
            $table->string('weather',20)->nullable();;
            $table->integer('PoP6h')->nullable();
            $table->integer('PoP12h')->nullable();
            $table->dateTime('get_day')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('enviroments');
    }
}
