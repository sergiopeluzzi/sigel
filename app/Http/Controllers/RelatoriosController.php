<?php

namespace App\Http\Controllers;

use Anouar\Fpdf\Fpdf;
use App\Competidor;
use App\Evento;
use App\Inscricao;
use App\Prova;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PhpSpec\Exception\Exception;

class RelatoriosController extends Controller
{
    private $evento;
    private $inscricao;
    private $competidor;
    private $data;
    private $prova;

    public function __construct(Evento $evento, Inscricao $inscricao, Competidor $competidor, Prova $prova)
    {
        $this->evento = $evento;
        $this->inscricao = $inscricao;
        $this->competidor = $competidor;
        $this->prova = $prova;
        $this->data['titPagina'] = 'Relatorios';
        $this->data['descPagina'] = 'Geração de relatórios em PDF';
    }

    public function teste()
    {
        $fpdf = new Fpdf();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(40,10,'Hello World!');
        $fpdf->Output();
        exit;
    }

    public function listaGeral()
    {
        return view('relatorios.listageral')->with($this->data);
    }

    public function imprimirListaGeral(Request $request)
    {
        $filtro = $request->get('order');

        $competidores = $this->competidor->orderBy($filtro, 'asc')->get();

        $fpdf = new Fpdf();
        $fpdf->AddPage();
        //Titulo
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(0, 15,"Lista geral dos competidores", 0, 1, 'C');
        //Cabeçalho
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(10,5,'Id', 1, 0, 'C');
        $fpdf->Cell(60,5,'Nome', 1, 0, 'C');
        $fpdf->Cell(60,5,'Apelido', 1, 0, 'C');
        $fpdf->Cell(30,5,'HC Cabeça', 1, 0, 'C');
        $fpdf->Cell(30,5,'HC Pé', 1, 1, 'C');
        //Registros
        $fpdf->SetFont('Arial','',10);
        foreach ($competidores as $competidor) {
            $fpdf->Cell(10,5,$competidor->id, 1, 0, 'C');
            $fpdf->Cell(60,5,$competidor->nome, 1);
            $fpdf->Cell(60,5,$competidor->apelido, 1);
            $fpdf->Cell(30,5,$competidor->handcapcabeca, 1, 0, 'C');
            $fpdf->Cell(30,5,$competidor->handcappe, 1, 1, 'C');
        }

        $fpdf->Cell(0,5,"(ordenado por: $filtro)", 0, 1, 'R');

        $fpdf->Output();
        exit;
    }

    public function marcacaoProva()
    {
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();
        return view('relatorios.marcacaoprova')->with($this->data);
    }

    public function imprimirMarcacaoProva(Request $request)
    {
        $evento = $this->evento->find($request->get('idevento'));
        if($request->get('ordem') == 'p') {
            $inscricoes = $this->inscricao->where('idevento', $evento->id)->orderBy('ordemCompeticao', 'desc')->orderBy('created_at', 'asc')->get();
        } else if ($request->get('ordem') == 'n') {
            $inscricoes = $this->inscricao->where('idevento', $evento->id)->orderBy('ordemCompeticao', 'asc')->orderBy('created_at', 'asc')->get();
        }

        $fpdf = new Fpdf();
        $fpdf->AddPage('L');
        //Titulo
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(0, 15,'Marcação da Prova: ' . $evento->nome, 0, 1, 'C');
        //Cabeçalho
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(10,5,'Ord', 1, 0, 'C');
        $fpdf->Cell(55,5,'Cabeça', 1, 0, 'C');
        $fpdf->Cell(55,5,'Pé', 1, 0, 'C');
        $fpdf->Cell(10,5,'HT', 1, 0, 'C');
        for ($i = 1; $i <= $evento->qntdebois; $i++) {
            $fpdf->Cell(18, 5, 'Boi ' . $i, 1, 0, 'C');
        }
        $fpdf->Cell(18, 5, 'Final', 1, 1, 'C');
        //registro
        $fpdf->SetFont('Arial','',10);
        $pos = 1;
        foreach ($inscricoes as $inscricao) {
            $fpdf->Cell(10, 12, $pos . 'º', 1, 0, 'C');
            $fpdf->Cell(10, 12, $this->competidor->find($inscricao->idcompetidorcabeca)->id, 1, 0, 'C');
            $fpdf->Cell(45, 12, $this->competidor->find($inscricao->idcompetidorcabeca)->nome, 1, 0, 'L');
            $fpdf->Cell(10, 12, $this->competidor->find($inscricao->idcompetidorpe)->id, 1, 0, 'C');
            $fpdf->Cell(45, 12, $this->competidor->find($inscricao->idcompetidorpe)->nome, 1, 0, 'L');
            $fpdf->Cell(10, 12, $this->competidor->find($inscricao->idcompetidorcabeca)->handcapcabeca + $this->competidor->find($inscricao->idcompetidorpe)->handcappe , 1, 0, 'C');
            for ($i = 1; $i <= $evento->qntdebois; $i++) {
                $fpdf->Cell(18, 12, ' ', 1, 0, 'C');
            }
            $fpdf->Cell(18, 12, '', 1, 1, 'C');
            $pos++;
        }

        $fpdf->Output();
        exit;
    }

    public function ficha()
    {
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();
        $this->data['competidores'] = $this->competidor->orderBy('nome', 'asc')->get();
        return view('relatorios.ficha')->with($this->data);
    }

    public function imprimirFicha(Request $request)
    {

        $dados = $request->all();
        $valorTotal = 0;

        $evento = $this->evento->find($dados['idevento']);
        $competidor = $this->competidor->find($dados['idcompetidor']);
        $inscricaoCabeca = $this->inscricao->where('idcompetidorcabeca', $competidor->id)
                                           ->where('idevento', $evento->id)
                                           ->orderBy('ordemCompeticao', 'asc')
                                           ->get();
        $inscricaoPe = $this->inscricao->where('idcompetidorpe', $competidor->id)
                                       ->where('idevento', $evento->id)
                                       ->orderBy('ordemCompeticao', 'asc')
                                       ->get();

        $fpdf = new Fpdf();
        $fpdf->AddPage();
        //Titulo
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(0, 15,'Ficha do Competidor', 0, 1, 'C');
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(0, 5,'Evento: ' . $evento->nome, 0, 1, 'L');
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(0, 5,'Competidor: ' . $competidor->nome . " * " . $competidor->apelido, 0, 1, 'L');
        $fpdf->Ln();
        //Cabeçalho kbça
        $fpdf->SetFont('Arial','B',12);
        $fpdf->Cell(145,5,'Inscrito como Cabeça', 0, 1, 'C');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(10, 5,'O.C.', 1, 0, 'C');
        $fpdf->Cell(10, 5,'O.I.', 1, 0, 'C');
        $fpdf->Cell(95, 5,'Competidor Pé', 1, 0, 'C');
        $fpdf->Cell(30, 5,'Valor', 1, 1, 'C');
        //Registros kbça
        $fpdf->SetFont('Arial','',10);
        foreach($inscricaoCabeca as $inscricao) {
            $fpdf->Cell(10, 5,$inscricao->ordemCompeticao . 'º', 1, 0, 'C');
            $fpdf->Cell(10, 5,$inscricao->ordemInscricao, 1, 0, 'C');
            $pezeiro = $this->competidor->find($inscricao->idcompetidorpe);
            $fpdf->Cell(95, 5,$pezeiro->id . ' - ' . $pezeiro->nome . " * " . $pezeiro->apelido, 1, 0, 'L');
            if($inscricao->ordemInscricao <= $evento->qntInscricoesComDesconto) {
                $fpdf->Cell(30, 5,'R$' . number_format($evento->valorComDesconto, 2 , ',', '.') , 1, 1, 'R');
                $valorTotal += $evento->valorComDesconto;
            } else {
                $fpdf->Cell(30, 5,'R$' . number_format($evento->valor, 2 , ',', '.') , 1, 1, 'R');
                $valorTotal += $evento->valor;
            }
        }

        $fpdf->Ln();

        //Cabeçalho peh
        $fpdf->SetFont('Arial','B',12);
        $fpdf->Cell(145,5,'Inscrito como Pé', 0, 1, 'C');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(10, 5,'O.C.', 1, 0, 'C');
        $fpdf->Cell(10, 5,'O.I.', 1, 0, 'C');
        $fpdf->Cell(95, 5,'Competidor Cabeça', 1, 0, 'C');
        $fpdf->Cell(30, 5,'Valor', 1, 1, 'C');
        //Registros Pé
        $fpdf->SetFont('Arial','',10);
        foreach($inscricaoPe as $inscricao) {
            $fpdf->Cell(10, 5,$inscricao->ordemCompeticao . 'º', 1, 0, 'C');
            $fpdf->Cell(10, 5,$inscricao->ordemInscricao, 1, 0, 'C');
            $cabeceiro = $this->competidor->find($inscricao->idcompetidorcabeca);
            $fpdf->Cell(95, 5,$cabeceiro->id . ' - ' . $cabeceiro->nome . " * " . $cabeceiro->apelido, 1, 0, 'L');
            if($inscricao->ordemInscricao <= $evento->qntInscricoesComDesconto) {
                $fpdf->Cell(30, 5,'R$' . number_format($evento->valorComDesconto, 2 , ',', '.') , 1, 1, 'R');
                $valorTotal += $evento->valorComDesconto;
            } else {
                $fpdf->Cell(30, 5,'R$' . number_format($evento->valor, 2 , ',', '.') , 1, 1, 'R');
                $valorTotal += $evento->valor;
            }
        }

        $fpdf->Ln();
        $fpdf->SetFont('Arial','B',12);
        $fpdf->Cell(115, 5,'Total:', 1, 0, 'R');
        $fpdf->Cell(30, 5,'R$ ' . number_format($valorTotal, 2, ',', '.'), 1, 1, 'R');

        $fpdf->SetY(-26);
        $fpdf->SetFont('Arial','',8);
        $fpdf->Cell(0, 5,'O.C. = Ordem de Competição/Corrida | O.I = Ordem de Inscrição', 0, 0, 'R');

        $fpdf->Output();
        exit;
    }

    public function listaProva()
    {
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();
        return view('relatorios.listaprova')->with($this->data);
    }

    public function imprimirListaProva(Request $request)
    {
        $evento = $this->evento->find($request->get('idevento'));
        $inscricoes = $this->inscricao->where('idevento', $evento->id)->get();
        $competidores = $this->competidor->all();

        $fpdf = new Fpdf();
        $fpdf->AddPage();
        //Titulo
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(0, 15,"Lista de competidores na prova: " . $evento->nome, 0, 1, 'C');
        //Cabeçalho
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(10,5,'Id', 1, 0, 'C');
        $fpdf->Cell(55,5,'Nome', 1, 0, 'C');
        $fpdf->Cell(55,5,'Apelido', 1, 0, 'C');
        $fpdf->Cell(35,5,'Inscrições Cabeça', 1, 0, 'C');
        $fpdf->Cell(35,5,'Inscrições Pé', 1, 1, 'C');
        //Registros
        $fpdf->SetFont('Arial','',10);
        foreach ($competidores as $competidor) {
            $fpdf->Cell(10,5,$competidor->id, 1, 0, 'C');
            $fpdf->Cell(55,5,$competidor->nome, 1);
            $fpdf->Cell(55,5,$competidor->apelido, 1);
            $fpdf->Cell(35,5,$inscricoes->where('idcompetidorcabeca', $competidor->id)->where('idevento', $evento->id)->count(), 1, 0, 'C');
            $fpdf->Cell(35,5,$inscricoes->where('idcompetidorpe', $competidor->id)->where('idevento', $evento->id)->count(), 1, 1, 'C');
        }
        $fpdf->Output();
        exit;

    }

    public function contas()
    {
        $this->data['eventos'] = $this->evento->orderBy('id', 'desc')->get();
        return view('relatorios.contas')->with($this->data);
    }

    public function imprimirContas(Request $request)
    {
        $dados = $request->all();

        $evento = $this->evento->find($dados['idevento']);
        $inscricoes = $this->inscricao->where('idevento', $evento->id)->get();

        //$inscricoes->count();

    }
}
