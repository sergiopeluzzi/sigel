<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    protected $table = 'provas';

    protected $fillable = [
        'idEvento',
        'idinscricao',
        'ordem',
        'boi',
        'pontuacao'
    ];
}
