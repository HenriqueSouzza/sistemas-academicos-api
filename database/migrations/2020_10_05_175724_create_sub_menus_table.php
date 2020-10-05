<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd.SUB_MENUS', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_MENU');
            $table->string('NOME');
            $table->string('LINK');
            $table->string('ICON')->nullable();
            $table->integer('ATIVO');
            $table->dateTime('CREATED_AT');
            $table->dateTime('UPDATED_AT');
            $table->softDeletes('DELETED_AT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cd.SUB_MENUS');
    }
}
