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
            $table->integer('ATIVO');
            $table->integer('PERMITE_ABERTURA_TICKET'); //coluna para validar se essa categoria permite abertura de ticket
            $table->integer('PERMITE_INTERACAO'); //Coluna para validar se essa categoria permite interacao de ticket
            $table->integer('PERMITE_N_TICKETS_ABERTOS'); //Coluna para validar se essa categoria permite abrir vários tickets mesmo estando um em aberto pelo o usuário
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
