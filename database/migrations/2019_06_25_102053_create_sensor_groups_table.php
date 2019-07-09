<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_groups', function (Blueprint $table) {
            $table->increments('sensor_group_id');
            $table->integer('workspace_id')->unsigned();
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->integer('field_id')->unsigned()->default(0);
            $table->foreign('field_id')->references('id')->on('fields');
            $table->integer('pond_id')->unsigned()->default(0);
            $table->foreign('pond_id')->references('id')->on('ponds');
            
            $table->string('sensor_name', 20)->default('')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->tinyInteger('is_open')->default(0)->nullable();
            $table->tinyInteger('is_deleted')->default(0)->nullable();
            
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
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
        Schema::dropIfExists('sensor_groups');
    }
}
