<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricoes';

    protected $fillable = [
        'ordemCompeticao',
        'ordemInscricao',
        'idevento',
        'idcompetidorcabeca',
        'idcompetidorpe'
    ];
}
