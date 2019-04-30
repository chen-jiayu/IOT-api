<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workspace_id')->unsigned()->default(0);
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->integer('field_id')->unsigned()->default(0);
            $table->foreign('field_id')->references('id')->on('fields');
            $table->integer('supplier_id')->unsigned()->default(0);
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->string('feed_size', 20)->default('');
            $table->decimal('inventory_weight', 8, 2)->default(0);
            $table->decimal('inventory_min', 8, 2)->default(0);
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
        Schema::dropIfExists('field_feeds');
    }
}
