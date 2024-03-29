<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexoTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd.ANEXO_TICKET', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('ID_TICKET');
            $table->integer('ID_INTERACAO_TICKET')->nullable();
            $table->string('ARQUIVO');
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
        Schema::dropIfExists('cd.ANEXO_TICKET');
    }
}
