<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventosValorColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->double('valor')->after('datafim');
            $table->double('valorComDesconto')->after('valor');
            $table->integer('qntInscricoesComDesconto')->after('valorComDesconto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('valor');
            $table->dropColumn('valorComDesconto');
            $table->dropColumn('qntComDesconto');
        });
    }
}
