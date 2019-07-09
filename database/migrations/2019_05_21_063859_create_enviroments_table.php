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
            $table->string('state',20);
            $table->string('district',20);
            $table->string('state_id',20);
            $table->foreign('state_id')->references('id')->on('states');
            $table->string('district_id',20);
            $table->foreign('district_id')->references('id')->on('districts');
            $table->dateTime('DAY')->nullable();
            $table->time('TIME')->nullable();
            $table->decimal('TEMP', 5, 2)->nullable();
            $table->integer('TD')->nullable();
            $table->integer('RH')->nullable();
            $table->string('BF',20)->nullable();
            $table->string('WIND',20)->nullable();
            $table->string('Wx',20)->nullable();
            $table->decimal('HOUR_6', 5, 2)->nullable();
            $table->decimal('AT', 5, 2)->nullable();
            $table->string('WS')->nullable();
            $table->integer('PoP6h')->nullable();
            $table->integer('PoP12h')->nullable();
            $table->dateTime('get_day');
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
