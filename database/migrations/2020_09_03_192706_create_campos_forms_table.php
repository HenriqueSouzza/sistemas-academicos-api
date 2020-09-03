<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamposFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd.CAMPOS_FORMS', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('DESCRICAO');
            $table->string('LABEL');
            $table->string('NAME');
            $table->string('CAMPO_ID');
            $table->string('VALUE');
            $table->integer('OBRIGATORIO');
            $table->integer('VISIVEL');
            $table->integer('EDITAVEL');
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
        Schema::dropIfExists('cd.CAMPOS_FORMS');
    }
}
