<?php

namespace App\Http\Controllers;

use App\Competidor;
use App\Evento;
use App\Http\Requests\InscricoesRequest;
use App\Inscricao;
use Grimthorr\LaravelToast\Toast;



class InscricoesController extends Controller
{
    private $evento;
    private $data;
    private $toast;
    private $inscricao;
    private $competidor;

    public function __construct(Evento $evento, Inscricao $inscricao, Competidor $competidor, Toast $toast)
    {
        $this->inscricao = $inscricao;
        $this->competidor = $competidor;
        $this->evento = $evento;
        $this->data['titPagina'] = 'Inscrições';
        $this->data['descPagina'] = 'Realizar inscrição dos competidores';
        $this->toast = $toast;
    }

    public function index()
    {
        $this->data['competidores'] = $this->competidor->all();
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();
        $this->data['inscricoes'] = $this->inscricao->all();
        return view('inscricoes.index')->with($this->data);
    }

    public function inscrever(InscricoesRequest $request)
    {
        $qnt = $request->get('qntdeinscricoes');

        for($i = 0; $i < $qnt; $i++) {
            $this->inscricao->create($request->all());
        }
        $this->toast->message('Adicionado com sucesso', 'success', "COD. INSCRIÇÃO: {$this->inscricao->latest()->first()->id}");
        return redirect()->route('inscricoes.index');
    }

    public function destroy($id)
    {
        $this->inscricao->find($id)->delete();
        $this->toast->message('Excluído com sucesso', 'error', "INSCRIÇÃO: {$id}");
        return redirect()->route('inscricoes.index');
    }

}
