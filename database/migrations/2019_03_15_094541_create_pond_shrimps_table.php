<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePondShrimpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pond_shrimps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workspace_id')->unsigned();
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->integer('field_id')->unsigned()->default(0);
            $table->foreign('field_id')->references('id')->on('fields');
            $table->integer('pond_id')->unsigned()->default(0);
            $table->foreign('pond_id')->references('id')->on('ponds');
            $table->integer('supplier_id')->unsigned()->default(0);
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->string('babysprimp', 20)->default('')->nullable();
            $table->string('shrimp_type', 20)->default('')->nullable();
            $table->decimal('number', 7, 3)->default(0)->nullable();
            $table->decimal('density', 5, 2)->default(0)->nullable();
            $table->dateTime('start_date')->nullable(); 
            $table->dateTime('end_date')->nullable(); 
            $table->string('note',300)->nullable();
            $table->tinyInteger('is_closed')->default(0)->nullable();
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
        Schema::dropIfExists('pond_shrimps');
    }
}
