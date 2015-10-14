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
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();
        return view('inscricoes.index')->with($this->data);
    }

    public function inscricoes()
    {
        $this->data['competidores'] = $this->competidor->all();
        $this->data['evento'] = $this->evento->find($_REQUEST['idevento']);
        $this->data['inscricoes'] = $this->inscricao->where('idevento', $_REQUEST['idevento'])->get();
        return view('inscricoes.inscricoes')->with($this->data);
    }

    public function inscrever(InscricoesRequest $request)
    {
        $this->data['competidores'] = $this->competidor->all();
        $this->data['evento'] = $this->evento->find($_REQUEST['idevento']);
        $this->data['inscricoes'] = $this->inscricao->where('idevento', $_REQUEST['idevento'])->get();

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
            return view('inscricoes.inscricoes')->with($this->data);
        }

        if (($qntInscricoesEvento + $qntDeInscricoes) > $evento->maxnuminscricoes) {
            $this->toast->message('Número de inscrições excede a quantidade permitida pelo evento!', 'error', 'Falha ao inscrever');
            return view('inscricoes.inscricoes')->with($this->data);
        }

        if (($qntTotalDeInscricoesDoCabeca + $qntDeInscricoes) > $evento->maxnuminscricoesporpessoa) {
            $this->toast->message('Competidor cabeça excede a quantidade de inscricoes por pessoa!', 'error', 'Falha ao inscrever');
            return view('inscricoes.inscricoes')->with($this->data);
        }

        if (($qntTotalDeInscricoesDoPe + $qntDeInscricoes) > $evento->maxnuminscricoesporpessoa) {
            $this->toast->message('Competidor pé excede a quantidade de inscricoes por pessoa!', 'error', 'Falha ao inscrever');
            return view('inscricoes.inscricoes')->with($this->data);
        }

        if (($qntInscricoesCabeca + $qntDeInscricoes) > $evento->maxnuminscricoesporhandcap) {
            $this->toast->message('Competidor cabeça excede a quantidade de inscricoes por handcap!', 'error', 'Falha ao inscrever');
            return view('inscricoes.inscricoes')->with($this->data);
        }

        if (($qntInscricoesPe + $qntDeInscricoes) > $evento->maxnuminscricoesporhandcap) {
            $this->toast->message('Competidor pé excede a quantidade de inscricoes por handcap!', 'error', 'Falha ao inscrever');
            return view('inscricoes.inscricoes')->with($this->data);
        }

        $m = $this->inscricao->where('idevento', $evento->id)
                             ->where('idcompetidorcabeca', $request->get('idcompetidorcabeca'))
                             ->where('idcompetidorpe', $request->get('idcompetidorpe'))
                             ->max('ordemCompeticao');

        for($i = 0; $i < $qntDeInscricoes; $i++) {
            $dados = $request->all();
            $dados['ordemInscricao'] = $this->inscricao->where('idevento', $dados['idevento'])->max('ordemInscricao') + 1;

            if ($m == 0) {
                $m = $this->inscricao->select('idcompetidorcabeca', 'idcompetidorpe')
                    ->where('idevento', $evento->id)
                    ->distinct()
                    ->get()
                    ->count();
                $m += 1;
                $dados['ordemCompeticao'] = $m;
            } else {
                $m += $this->evento->find($dados['idevento'])->pulaquantos;
                $dados['ordemCompeticao'] = $m;
            }

            $this->inscricao->create($dados);

        }

        $this->toast->message('Inscrição(ões) feita(s) com sucesso', 'success', "EVENTO: {$request->get('idevento')}");
        return redirect()->route('inscricoes.index');
    }

    public function destroy($id)
    {
        $this->inscricao->find($id)->delete();
        $this->toast->message('Excluído com sucesso', 'error', "INSCRIÇÃO: {$id}");
        return redirect()->route('inscricoes.index');
    }

}

