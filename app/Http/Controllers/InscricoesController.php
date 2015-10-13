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
        $qntTotalDeInscricoesDoCabeca = $this->inscricao->where('idcompetidorcabeca', $request->get('idcompetidorcabeca'))->where('idevento', $evento->id)->count() +
                                        $this->inscricao->where('idcompetidorpe', $request->get('idcompetidorcabeca'))->where('idevento', $evento->id)->count();
        $qntTotalDeInscricoesDoPe = $this->inscricao->where('idcompetidorcabeca', $request->get('idcompetidorpe'))->where('idevento', $evento->id)->count() +
                                    $this->inscricao->where('idcompetidorpe', $request->get('idcompetidorpe'))->where('idevento', $evento->id)->count();


        if ($request->get('idcompetidorcabeca') == $request->get('idcompetidorpe')) {
            $this->toast->message('Competidor cabeça e Competidor pé não podem ser iguais!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }

        if (($qntInscricoesEvento + $qntDeInscricoes) > $evento->maxnuminscricoes) {
            $this->toast->message('Número de inscrições excede a quantidade permitida pelo evento!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }

        if (($qntTotalDeInscricoesDoCabeca + $qntDeInscricoes) > $evento->maxnuminscricoesporpessoa) {
            $this->toast->message('Competidor cabeça excede a quantidade de inscricoes por pessoa!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }

        if (($qntTotalDeInscricoesDoPe + $qntDeInscricoes) > $evento->maxnuminscricoesporpessoa) {
            $this->toast->message('Competidor pé excede a quantidade de inscricoes por pessoa!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }

        if (($qntInscricoesCabeca + $qntDeInscricoes) > $evento->maxnuminscricoesporhandcap) {
            $this->toast->message('Competidor cabeça excede a quantidade de inscricoes por handcap!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }

        if (($qntInscricoesPe + $qntDeInscricoes) > $evento->maxnuminscricoesporhandcap) {
            $this->toast->message('Competidor pé excede a quantidade de inscricoes por handcap!', 'error', 'Falha ao inscrever');
            return redirect()->route('inscricoes.index');
        }

        $m = 0;

        for($i = 0; $i < $qntDeInscricoes; $i++) {
            $dados = $request->all();

            if ($m == 0) {
                $m = 1;
                $dados['ordemCompeticao'] = $m;
            } else {
                $m += $this->evento->find($dados['idevento'])->pulaquantos;
                $dados['ordemCompeticao'] = $m;
            }

            $dados['ordemInscricao'] = $this->inscricao->where('idevento', $dados['idevento'])->max('ordemInscricao') + 1;
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

