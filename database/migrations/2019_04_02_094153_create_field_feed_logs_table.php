<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldFeedLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_feed_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workspace_id')->unsigned()->default(0);
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->tinyInteger('source_type')->default(0)->nullable();

            $table->integer('field_id')->unsigned()->default(0);
            $table->foreign('field_id')->references('id')->on('fields');

            $table->integer('daily_note_id')->unsigned()->nullable();
            $table->foreign('daily_note_id')->references('id')->on('daily_notes');
            $table->integer('feed_id')->unsigned()->nullable();
            $table->foreign('feed_id')->references('id')->on('field_feeds');
            $table->decimal('inventory_weight', 8, 2)->default(0)->nullable();
            $table->integer('created_id')->nullable();
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
        Schema::dropIfExists('field_feed_logs');
    }
}
