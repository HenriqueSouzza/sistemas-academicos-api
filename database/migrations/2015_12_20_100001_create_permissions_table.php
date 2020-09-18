<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PERMISSIONS', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('NAME', 50);
            $table->string('SLUG')->unique();
            $table->string('RESOURCE', 20)->default('System');
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
        Schema::drop('PERMISSIONS');
    }
}
