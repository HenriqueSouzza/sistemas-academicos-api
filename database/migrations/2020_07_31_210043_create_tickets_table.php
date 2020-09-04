<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Executa a criação das migrations
     * https://laravel.com/docs/7.x/migrations#creating-tables
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('cd.TICKET', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('USUARIO');
            $table->integer('ID_PAPEL_USUARIO');
            $table->string('ID_SETOR');
            $table->string('ID_CATEGORIA');
            $table->string('ASSUNTO');
            $table->text('MENSAGEM');
            $table->string('USUARIO_ATENDENTE')->nullable();
            $table->string('USUARIO_FECHAMENTO')->nullable();
            $table->string('DT_FECHAMENTO')->nullable();
            $table->string('ABERTO')->nullable();
            $table->string('PENDENTE')->nullable();
            $table->string('FECHADO')->nullable();
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
        Schema::dropIfExists('cd.TICKET');
    }
}
