<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetidoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competidores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cidade');
            $table->string('apelido');
            $table->float('handcapcabeca');
            $table->float('handcappe');
            $table->string('telefone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('competidores');
    }
}
