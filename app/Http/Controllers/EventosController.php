<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventosController extends Controller
{
    public function index()
    {
        $data['titPagina'] = 'Eventos';
        $data['descPagina'] = 'Lista dos Eventos/Provas cadastrados';

        return view('eventos.index')->with($data);
    }
}
