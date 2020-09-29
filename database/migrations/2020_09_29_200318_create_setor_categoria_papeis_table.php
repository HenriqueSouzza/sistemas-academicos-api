<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetorCategoriaPapeisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd.SETOR_CATEGORIA_PAPEIS', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('FK_PAPEIS');
            $table->integer('FK_SETOR');
            $table->integer('FK_CATEGORIA');
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
        Schema::dropIfExists('cd.SETOR_CATEGORIA_PAPEIS');
    }
}
