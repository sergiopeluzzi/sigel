<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PrincipalController extends Controller
{
    public function index()
    {
        $data['titPagina'] = 'Principal';

        $data['menu'] = [
            [
                'nome' => 'Competidores',
                'descricao' => 'No menu Competidores são cadastrados as pessoas que irão participar dos Eventos. O competidor pode fazer inscrição em mais de um evento, por isso não é necessário cadastrá-lo a cada prova'
            ],
            [
                'nome' => 'Eventos',
                'descricao' => 'No menu Eventos são cadastrados os eventos/provas que os competidores participarão, bem como as sua respectivas regras.'
            ]
        ];

        return view('template')->with($data);
    }
}
