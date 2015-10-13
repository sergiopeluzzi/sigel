<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'nome',
        'descricao',
        'cidade',
        'datainicio',
        'datafim',
        'valor',
        'valorComDesconto',
        'qntInscricoesComDesconto',
        'maxnuminscricoes',
        'maxnuminscricoesporpessoa',
        'maxnuminscricoesporhandcap',
        'maxnuminscricoescommesmocompetidor',
        'qntdebois',
        'pulaquantos'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'datainicio',
        'datafim'
    ];
}
