<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PERMISSION_ROLE', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->bigInteger('PERMISSION_ID')->unsigned()->index();
            $table->foreign('PERMISSION_ID')->references('ID')->on('PERMISSIONS')->onDelete('cascade');
            $table->bigInteger('ROLE_ID')->unsigned()->index();
            $table->foreign('ROLE_ID')->references('ID')->on('ROLES')->onDelete('cascade');
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
        Schema::drop('permission_role');
    }
}
