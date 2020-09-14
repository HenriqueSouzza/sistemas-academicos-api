<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ROLE_USER', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->bigInteger('ROLE_ID')->unsigned()->index();
            $table->foreign('ROLE_ID')->references('ID')->on('ROLES')->onDelete('cascade');
            $table->bigInteger('USER_ID')->unsigned()->index();
            $table->foreign('USER_ID')->references('ID')->on('USERS')->onDelete('cascade');
            $table->dateTime('CREATED_AT');
            $table->dateTime('UPDATED_AT');
            $table->softDeletes('DELETED_AT');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_user');
    }
}
