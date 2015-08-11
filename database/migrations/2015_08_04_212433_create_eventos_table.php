<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('cidade')->nullable();
            $table->date('datainicio');
            $table->date('datafim');
            $table->integer('maxnuminscricoes')->default(0);
            $table->integer('maxnuminscricoesporpessoa')->default(0);
            $table->integer('maxnuminscricoesporhandcap')->default(0);
            $table->integer('maxnuminscricoescommesmocompetidor')->default(0);
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
        Schema::drop('eventos');
    }
}
