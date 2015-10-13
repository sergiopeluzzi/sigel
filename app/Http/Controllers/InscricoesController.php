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
        $evento = $this->evento->find($request->get('idevento'));
        $qntDeInscricoes = $request->get('qntdeinscricoes');
        $qntInscricoesEvento = $this->inscricao->where('idevento', $evento->id)->count();
        $qntInscricoesCabeca = $this->inscricao->where('idcompetidorcabeca', $request->get('idcompetidorcabeca'))->where('idevento', $evento->id)->count();
        $qntInscricoesPe = $this->inscricao->where('idcompetidorpe', $request->get('idcompetidorpe'))->where('idevento', $evento->id)->count();


        if ($request->get('idcompetidorcabeca') == $request->get('idcompetidorpe')) {
            $this->toast->message('Competidor cabeça e Competidor pé não podem ser iguais!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }

        if (($qntInscricoesEvento + $qntDeInscricoes) > $evento->maxnuminscricoes) {
            $this->toast->message('Número de inscrições excede a quantidade permitida pelo evento!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }



        for($i = 0; $i < $qntDeInscricoes; $i++) {
            $dados = $request->all();
            $m = $this->inscricao->where('idevento', $dados['idevento'])->max('ordemCompeticao');
            $dados['ordemInscricao'] = $this->inscricao->where('idevento', $dados['idevento'])->max('ordemInscricao') + 1;
            $dados['ordemCompeticao'] = $m == 0 ? 1 : $m + $this->evento->find($dados['idevento'])->pulaquantos;
            $this->inscricao->create($dados);
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
