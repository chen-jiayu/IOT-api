<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workspace_id')->unsigned()->nullable();
            $table->foreign('workspace_id')->references('id')->on('workspaces');
            $table->tinyInteger('supplier_type')->default(0);
            $table->string('supplier_name', 20)->default('');
            $table->string('contact_name_1', 15)->default('');
            $table->string('contact_phone_1', 15)->default('');
            $table->string('contact_name_2', 15)->default('');
            $table->string('contact_phone_2', 15)->default('');
            $table->string('address', 40)->default('');
            $table->string('note', 200)->default('');
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
        Schema::dropIfExists('suppliers');
    }
}
