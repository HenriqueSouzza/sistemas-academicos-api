<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapeisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PAPEIS', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('PAPEL', 50);
            $table->string('DESCRICAO', 100);
            $table->integer('SISTEMA');
            $table->integer('FK_FORMULARIO')->nullable();
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
        Schema::dropIfExists('PAPEIS');
    }
}
