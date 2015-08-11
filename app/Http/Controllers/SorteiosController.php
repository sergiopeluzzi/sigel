<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SorteiosController extends Controller
{
    public function index()
    {
        $data['titPagina'] = 'Sorteios';
        $data['descPagina'] = 'Ordem das provas e seus competidores';

        return view('sorteios.index')->with($data);
    }
}
