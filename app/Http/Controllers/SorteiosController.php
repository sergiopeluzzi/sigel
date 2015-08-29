<?php

namespace App\Http\Controllers;

use App\Competidor;
use App\Evento;
use App\Inscricao;
use Grimthorr\LaravelToast\Toast;
use App\Http\Requests;
use Illuminate\Http\Request;

class SorteiosController extends Controller
{
    private $evento;
    private $inscricao;
    private $competidor;
    private $toast;
    private $data;

    public function __construct(Evento $evento, Inscricao $inscricao, Competidor $competidor, Toast $toast)
    {
        $this->evento = $evento;
        $this->inscricao = $inscricao;
        $this->competidor = $competidor;
        $this->toast = $toast;
        $this->data['titPagina'] = 'Provas';
        $this->data['descPagina'] = 'Ordem das provas e seus competidores';
    }

    public function index()
    {
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();;

        return view('sorteios.index')->with($this->data);
    }

    public function processar(Request $request)
    {
        dd($request->all());

        return redirect()->route('sorteios.visualizar');
    }

    public function visualizar(Request $request)
    {
        $this->data['inscricoes'] = $this->inscricao->where('idevento', $request->idevento)->get();
        $this->data['evento'] = $this->evento->find($request->idevento);

        return view('sorteios.visualizar')->with($this->data);
    }

    public function salvar()
    {
        $this->toast->message('Sucesso', 'success');

        return redirect()->route('sorteios.index');
    }
}
