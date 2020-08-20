<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd.CATEGORIA', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_SETOR');
            $table->string('DESCRICAO');
            $table->string('ATIVO');
            $table->string('PERMITE_ABERTURA');
            $table->string('PERMITE_INTERACAO');
            //PERMITE A ABERTURA DE VARIOS TICKETS DA MESMA CATEGORIA
            $table->string('PERMITE_N_TICKETS');
            $table->string('USUARIO');
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
        Schema::dropIfExists('cd.CATEGORIA');
    }
}
