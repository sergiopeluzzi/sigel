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
        'maxnuminscricoes',
        'maxnuminscricoesporpessoa',
        'maxnuminscricoesporhandcap',
        'maxnuminscricoescommesmocompetidor'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'datainicio',
        'datafim'
    ];
}
