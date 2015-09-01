<?php

namespace App\Http\Controllers;

use App\Competidor;
use App\Http\Requests;
use App\Http\Requests\CompetidoresRequest;
use Grimthorr\LaravelToast\Toast;

class CompetidoresController extends Controller
{
    private $competidor;
    private $data;
    private $toast;

    public function __construct(Competidor $competidor, Toast $toast)
    {
        $this->competidor = $competidor;
        $this->data['titPagina'] = 'Competidores';
        $this->data['descPagina'] = 'Lista dos Competidores cadastrados';
        $this->toast = $toast;
    }

    public function index()
    {
        $this->data['competidores'] = $this->competidor->all();
        return view('competidores.index')->with($this->data);
    }

    public function create()
    {
        return view('competidores.create')->with($this->data);
    }

    public function store(CompetidoresRequest $request)
    {
        $this->competidor->create($request->all());
        $this->toast->message('Adicionado com sucesso', 'success', "COMPETIDOR: {$this->competidor->latest()->first()->id}");
        return redirect()->route('competidores.index');
    }

    public function edit($id)
    {
        $this->data['competidor'] = $this->competidor->find($id);
        return view('competidores.edit')->with($this->data);
    }

    public function update($id, CompetidoresRequest $request)
    {
        $this->competidor->find($id)->update($request->all());
        $this->toast->message('Atualizado com sucesso', 'info', "COMPETIDOR: {$id}");
        return redirect()->route('competidores.index');
    }

    public function destroy($id)
    {
        $this->competidor->find($id)->delete();
        $this->toast->message('Excluído com sucesso', 'error', "COMPETIDOR: {$id}");
        return redirect()->route('competidores.index');
    }
}
