<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteracaoTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd.INTERACAO_TICKET', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_TICKET');
            $table->integer('ID_PAPEL_USUARIO');
            $table->string('USUARIO', 20);
            $table->text('MENSAGEM');
            $table->string('SITUACAO', 100);
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
        Schema::dropIfExists('cd.INTERACAO_TICKET');
    }
}