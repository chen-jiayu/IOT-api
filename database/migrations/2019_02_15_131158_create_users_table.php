<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name', 20);
            $table->string('mobile', 15)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('password', 200);
            $table->string('remeber_token', 400)->nullable();
            $table->integer('workspace_id')->nullable();
            $table->string('citizen_id', 15);
            $table->string('id_token', 200)->nullable();
            $table->tinyInteger('is_deleted')->default(0)->nullable();
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
        Schema::dropIfExists('users');
    }
}
