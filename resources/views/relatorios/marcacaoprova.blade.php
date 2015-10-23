@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h2>Relatório - Marcação da Prova</h2>
                    </div>

                    @if($errors->any())
                        <div class="bg-red">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel-body">

                        {!! Form::open(['route' => 'relatorios.imprimirMarcacaoProva', 'method' => 'post']) !!}
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="idevento">Evento:</label>
                                <select id="idevento" name="idevento" class="form-control">
                                    @foreach($eventos as $evento)
                                        <option value="{{ $evento->id }}">{{ $evento->id . ' - ' . $evento->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="ordem">Ordem da competição:</label>
                                <select id="ordem" name="ordem" class="form-control">
                                    <option value="n">Normal</option>
                                    <option value="p">Invertido</option>
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success" value="Salvar">
                                <i class="glyphicon glyphicon-print"></i> Gerar Relatório
                            </button>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop