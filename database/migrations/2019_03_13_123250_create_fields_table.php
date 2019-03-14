<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workspace_id')->unsigned()->nullable();
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->string('field_name', 20)->default('');
            $table->string('state_id', 20)->default('');
            $table->foreign('state_id')->references('id')->on('states');
            $table->string('field_position', 20)->default('');
            $table->tinyInteger('is_deleted')->default(0);
            $table->integer('created_id')->unsigned()->nullable();
            $table->integer('updated_id')->unsigned()->nullable();
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
        Schema::dropIfExists('fields');
    }
}
