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

    public function imprimelistaGeral()
    {

    }

    public function listaGeral()
    {
        $competidores = $this->competidor->all();

        $fpdf = new Fpdf();
        $fpdf->AddPage();
        //Titulo
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(0, 15,'Lista geral dos competidores', 0, 1, 'C');
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

        $fpdf->Output();
        exit;

    }

    public function marcacaoProva()
    {
        return view('relatorios.marcacaoprova')->with($this->data);
    }

    public function imprimirMarcacaoProva()
    {
        $evento = $this->evento->find(2);
        $inscricoes = $this->inscricao->where('idevento', $evento->id)->get();

        $fpdf = new Fpdf();
        $fpdf->AddPage('L');
        //Titulo
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(0, 15,'Marcação da Prova', 0, 1, 'C');
        //Cabeçalho
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(55,5,'Cabeça', 1, 0, 'C');
        $fpdf->Cell(55,5,'Pé', 1, 0, 'C');
        $fpdf->Cell(10,5,'HT', 1, 0, 'C');
        for ($i = 1; $i <= $evento->qntdebois; $i++) {
            $fpdf->Cell(15, 5, 'Boi ' . $i, 1, 0, 'C');
        }
        $fpdf->Cell(15, 5, 'Final', 1, 1, 'C');
        //registro
        $fpdf->SetFont('Arial','',10);
        foreach ($inscricoes as $inscricao) {
            $fpdf->Cell(5, 10, $this->competidor->find($inscricao->idcompetidorcabeca)->id, 1, 0, 'C');
            $fpdf->Cell(50, 10, $this->competidor->find($inscricao->idcompetidorcabeca)->nome, 1, 0, 'L');
            $fpdf->Cell(5, 10, $this->competidor->find($inscricao->idcompetidorpe)->id, 1, 0, 'C');
            $fpdf->Cell(50, 10, $this->competidor->find($inscricao->idcompetidorpe)->nome, 1, 0, 'L');
            $fpdf->Cell(10, 10, $this->competidor->find($inscricao->idcompetidorcabeca)->handcapcabeca + $this->competidor->find($inscricao->idcompetidorpe)->handcappe , 1, 0, 'C');
            for ($i = 1; $i <= $evento->qntdebois; $i++) {
                $fpdf->Cell(15, 10, ' ', 1, 0, 'C');
            }
            $fpdf->Cell(15, 10, '', 1, 1, 'C');
        }


        $fpdf->Output();
        exit;
    }

    public function ficha()
    {
        $fpdf = new Fpdf();
        $fpdf->AddPage();

        $fpdf->Output();
        exit;
    }
}
