<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ROLES', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('NAME');
            $table->string('SLUG')->unique();
            $table->text('DESCRIPTION')->nullable();
            $table->boolean('SYSTEM')->default(0);
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
        Schema::drop('roles');
    }
}
