<?php

namespace App\Http\Controllers;

use App\Competidor;
use App\Evento;
use App\Inscricao;
use App\Prova;
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
    private $prova;

    public function __construct(Evento $evento, Inscricao $inscricao, Competidor $competidor, Toast $toast, Prova $prova)
    {
        $this->evento = $evento;
        $this->inscricao = $inscricao;
        $this->competidor = $competidor;
        $this->toast = $toast;
        $this->prova = $prova;
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
        $temp = $request->all();
        $evento = $this->evento->find($temp['idevento']);
        $inscricoes = $this->inscricao->where('idevento', $evento->id)->get();

        if (empty($this->inscricao->where('idevento', $evento->id)->get()->toArray())) {
            $this->toast->message('Não existem inscrições a serem sorteadas neste evento!', 'error');
            return redirect()->route('sorteios.index');
        } else {
            foreach ($inscricoes as $inscricao) {
                if (!empty($this->prova->where('idinscricao', $inscricao->id)->get()->toArray())) {
                    $this->toast->message('Esse evento ja foi sorteado', 'info');
                    return redirect()->route('sorteios.index');
                } else {
                    $i = 1;
                    while ($i <= $evento->qntdebois) {
                        $data['idinscricao'] = $inscricao->id;
                        $data['boi'] = 'Boi'.$i;
                        $data['pontuacao'] = 0.0;
                        $this->prova->create($data);
                        $i++;
                    }
                }
            }
        }

        $this->toast->message('Sorteio Realizado com sucesso', 'success');
        return redirect()->route('sorteios.index');
    }

    public function visualizar(Request $request)
    {
        $this->data['inscricoes'] = $this->inscricao->where('idevento', $request->idevento)->get();
        $this->data['evento'] = $this->evento->find($request->idevento);
        return view('sorteios.visualizar')->with($this->data);
    }

    public function salvar(Request $request)
    {
        $this->toast->message('Pontuação salva com sucesso!', 'success');
        return redirect()->route('sorteios.index');
    }
}
