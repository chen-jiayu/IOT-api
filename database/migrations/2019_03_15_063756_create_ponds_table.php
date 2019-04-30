<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workspace_id')->unsigned()->nullable();
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->integer('field_id')->unsigned()->nullable();
            $table->foreign('field_id')->references('id')->on('fields');
            $table->string('pond_name', 20)->default('');
            $table->decimal('long', 5, 2)->default(0);
            $table->decimal('depth', 5, 2)->default(0);
            $table->decimal('width', 5, 2)->default(0);
            $table->integer('waterwheel')->default(0);
            $table->tinyInteger('is_closed')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('ponds');
    }
}
