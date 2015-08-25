<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Http\Requests\EventosRequest;
use Grimthorr\LaravelToast\Toast;
use App\Http\Requests;
use Carbon\Carbon;

class EventosController extends Controller
{
    private $evento;
    private $data;
    private $toast;

    public function __construct(Evento $evento, Toast $toast)
    {
        $this->evento = $evento;
        $this->data['titPagina'] = 'Eventos';
        $this->data['descPagina'] = 'Lista dos Eventos/Provas cadastrados';
        $this->toast = $toast;
    }

    public function index()
    {
        $this->data['eventos'] = $this->evento->all();

        return view('eventos.index')->with($this->data);
    }

    public function create()
    {
        return view('eventos.create')->with($this->data);
    }

    public function show($id)
    {
        $this->data['evento'] = $this->evento->find($id);

        return view('eventos.show')->with($this->data);
    }

    public function store(EventosRequest $request)
    {

        $this->evento->create($request->all());

        $this->toast->message('Adicionado com sucesso', 'success', "EVENTO: {$this->evento->latest()->first()->id}");

        return redirect()->route('eventos.index');
    }

    public function edit($id)
    {
        $this->data['evento'] = $this->evento->find($id);

        return view('eventos.edit')->with($this->data);
    }

    public function update($id, EventosRequest $request)
    {
        $this->evento->find($id)->update($request->all());

        $this->toast->message('Atualizado com sucesso', 'info', "EVENTO: {$id}");

        return redirect()->route('eventos.index');
    }

    public function destroy($id)
    {
        $this->evento->find($id)->delete();

        $this->toast->message('Excluído com sucesso', 'error', "EVENTO: {$id}");

        return redirect()->route('eventos.index');
    }
}
