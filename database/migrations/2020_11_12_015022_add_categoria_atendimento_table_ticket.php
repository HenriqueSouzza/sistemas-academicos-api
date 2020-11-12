<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriaAtendimentoTableTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Adicionado essa migration para não perder os registros da tabela
         */
        Schema::table('cd.TICKET', function (Blueprint $table) {
            $table->string('CATEGORIA_ATENDIMENTO')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
