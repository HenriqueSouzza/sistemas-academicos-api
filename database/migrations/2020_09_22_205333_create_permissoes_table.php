<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PERMISSOES', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('DESCRICAO', 100);
            $table->string('PERMISSAO', 250);
            $table->string('PREFIX', 150)->nullable();
            $table->string('ACTION_PERMISSOES', 200)->default('N/I');
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
        Schema::dropIfExists('PERMISSOES');
    }
}
