<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InscricoesController extends Controller
{

    public function index()
    {
        $data['titPagina'] = 'Inscrições';
        $data['descPagina'] = 'Lista de inscrições realizadas';

        return view('inscricoes.index')->with($data);
    }
}
