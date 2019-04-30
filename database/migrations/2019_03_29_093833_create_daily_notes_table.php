<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_notes', function (Blueprint $table) {
           $table->increments('id');
            $table->integer('workspace_id')->unsigned();
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->integer('pond_id')->unsigned();
            $table->foreign('pond_id')->references('id')->on('ponds');
            $table->integer('field_id')->unsigned();
            $table->foreign('field_id')->references('id')->on('fields');
            $table->integer('feed_id')->unsigned();
            $table->foreign('feed_id')->references('id')->on('field_feeds');
            $table->dateTime('note_date')->nullable();
           $table->timestamp('feeding_time');
            $table->decimal('feeding_wieght', 8, 2)->nullable();
            $table->integer('eating_duration')->nullable();
            $table->string('note',200);
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
        Schema::dropIfExists('daily_notes');
    }
}
