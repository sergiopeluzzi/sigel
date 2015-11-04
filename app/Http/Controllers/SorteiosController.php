<?php

namespace App\Http\Controllers;

use Anouar\Fpdf\Fpdf;
use App\Competidor;
use App\Evento;
use App\Inscricao;
use App\Prova;
use Grimthorr\LaravelToast\Toast;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();
        return view('sorteios.index')->with($this->data);
    }

    public function processar(Request $request)
    {
        $temp = $request->all();
        $evento = $this->evento->find($temp['idevento']);
        $inscricoes = $this->inscricao->where('idevento', $evento->id)->get();
        $ordem = 1;

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
                        $data['idEvento'] = $temp['idevento'];
                        $data['idinscricao'] = $inscricao->id;
                        $data['ordem'] = $ordem;
                        $data['boi'] = 'boi'.$i;
                        $data['pontuacao'] = 0.0;
                        $this->prova->create($data);
                        $ordem++;
                        $i++;
                    }
                }
            }
        }

        $max = $this->inscricao->where('idEvento', $temp['idevento'])->count();
        $c = 1;
        $ordemUpd = $this->getRandomNumbers($max, 1, $max);

        foreach ($inscricoes as $inscricao) {
            $inscricao->ordemCompeticao = $ordemUpd[$c-1];
            $inscricao->update();
            $c++;
        }

        $this->toast->message('Sorteio Realizado com sucesso', 'success');
        return redirect()->route('sorteios.index');
    }

    public function deletar(Request $request)
    {
        $evento = $this->evento->find($request->get('idevento'));

        if (empty($this->prova->where('idEvento', $evento->id)->get()->toArray())) {
            $this->toast->message('Esse evento não foi sorteado!', 'info');
            return redirect()->route('sorteios.index');
        } else {
            foreach ($this->prova->where('idEvento', $evento->id)->get() as $prova) {
                $prova->delete();
            }
            $this->toast->message('Sorteio Excluido com sucesso!', 'error');
            return redirect()->route('sorteios.index');
        }
    }

    public function visualizar(Request $request)
    {
        if($request->get('ordem') == 'n') {
            $this->data['inscricoes'] = $this->inscricao->where('idevento', $request->idevento)->orderBy('ordemCompeticao', 'asc')->get();
        } else if ($request->get('ordem') == 'p') {
            $this->data['inscricoes'] = $this->inscricao->where('idevento', $request->idevento)->orderBy('ordemCompeticao', 'desc')->orderBy('created_at', 'asc')->get();
        }
        $this->data['evento'] = $this->evento->find($request->idevento);
        $this->data['prova'] = $this->prova->all();

        $pos = 1;

        foreach ($this->data['inscricoes'] as $inscricao) {
            $inscricao->update(['ordemCompeticao' => $pos++]);
        }

        $this->data['pos'] = 1;
        return view('sorteios.visualizar')->with($this->data);
    }

    public function inserir(Request $request, $id)
    {
        $this->data['inscricao'] = $this->inscricao->find($id);
        $this->data['provas'] = $this->prova->where('idInscricao', $id)->get();
        $this->data['evento'] = $this->evento->find($this->data['inscricao']['idevento']);
        $this->data['prova'] = $this->prova->find($id);

        return view('sorteios.inserir')->with($this->data);
    }

    public function editar(Request $request)
    {
        return view('sorteios.editar')->with($this->data);
    }

    public function salvar(Request $request)
    {
        $this->data['inscricao'] = $this->inscricao->find($request->get('idinscricao'));
        $this->data['evento'] = $this->evento->find($this->data['inscricao']['idevento']);
        $this->data['eventos'] = $this->evento->all();
        $this->data['inscricoes'] = $this->inscricao->where('idevento', $this->data['evento']['id'])->get();
        $this->data['prova'] = $this->prova->all();
        $this->data['pos'] = 1;

        $qntdebois = $this->data['evento']->qntdebois;

        $i = 1;

        while ($i <= $qntdebois) {
            $dados['idEvento'] = $request->get('idevento');
            $dados['idinscricao'] = $request->get('idinscricao');
            $dados['boi'] = 'boi' . $i;
            $dados['pontuacao'] = $request->get('boi' . $i);

            if ($dados['pontuacao'] != '') {
                if($this->prova->where('idinscricao', $request->get('idinscricao'))->where('boi', 'boi'.$i)->count() == 0) {
                    $this->prova->create($dados);
                }
            }

            $i++;

            if($i == $qntdebois) {
                if($this->prova->where('idinscricao', $request->get('idinscricao'))->where('boi', 'boifinal')->count() == 0) {
                    $dados['boi'] = 'boifinal';
                    $dados['pontuacao'] = $request->get('boifinal');
                    $this->prova->create($dados);
                }
            }
        }



        $this->toast->message('Pontuação realizada com sucesso: Inscrição: ' . $this->data['inscricao']['id'], 'success');
        return view('sorteios.index')->with($this->data);
    }

    /**
     * Generates random numbers
     *
     * @author    Paulo Freitas <paulofreitas dot web at gmail dot com>
     * @copyright Copyright (C) 2006-2010  Paulo Freitas
     * @license   http://creativecommons.org/licenses/by-sa/3.0
     * @version   20100107
     * @param     int $num amount of numbers to generate
     * @param     int $min minimum number to generate
     * @param     int $max maximum number to generate
     * @param     bool $repeat if the numbers can repeat
     * @param     int|bool $sort if the numbers must be ordered (SORT_ASC to ascending order and SORT_DESC to descending order)
     * @return    array|bool array of generated numbers or false when invalid conditions
     */
    public function getRandomNumbers($num, $min, $max, $repeat = false, $sort = false)
    {
        if ((($max - $min) + 1) >= $num) {
            $numbers = array();

            while (count($numbers) < $num) {
                $number = mt_rand($min, $max);

                if ($repeat || !in_array($number, $numbers)) {
                    $numbers[] = $number;
                }
            }

            switch ($sort) {
                case SORT_ASC:
                    sort($numbers);
                    break;
                case SORT_DESC:
                    rsort($numbers);
                    break;
            }

            return $numbers;
        }

        return false;
    }


}
