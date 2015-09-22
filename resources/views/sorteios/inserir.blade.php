@extends('template')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h2>Inscrição: <b>{{ $inscricao->id }}</b></h2>
                        <table class="table table-bordered table-hover">
                            <thead class="bg-green-gradient">
                            <tr>
                                <th></th>
                                <th class="text-center">Competidor Cabeça</th>
                                <th class="text-center">Competidor Pé</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr>
                                <td>Nome</td>
                                <td class="text-center">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorcabeca)->apelido}}</td>
                                <td class="text-center">{{ \App\Competidor::find($inscricao->idcompetidorpe)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorpe)->apelido}}</td>
                            </tr>
                            <tr>
                                <td>Handcap</td>
                                <td class="text-center">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca }}</td>
                                <td class="text-center">{{ \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                            </tr>
                            <tr>
                                <td>HC Total</td>
                                <td class="text-center lead text-bold" colspan="2">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca + \App\Competidor::find($inscricao->idcompetidorpe)->handcappe}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                            {!! Form::model($provas, ['route' => ['sorteios.salvar', $provas->first()->Id], 'method' => 'put']) !!}
                                {!! Form::input('hidden', 'idinscricao', $inscricao->id) !!}
                                @foreach($provas as $prova)
                                    <div class="row center-block">
                                        <div class="text-center">
                                            {!! Form::label($prova->boi, $prova->boi) !!}
                                            {!! Form::input('number', $prova->boi, null, ['class' => 'form-control', 'step' => 'any']) !!} (segundos)
                                        </div>
                                    </div>
                                <br/>
                                @endforeach
                            <div class="row center-block">
                                <div class="text-center">
                                    {!! Form::label('boifinal', 'Boi Final') !!}
                                    {!! Form::input('number', 'boifinal', null, ['class' => 'form-control', 'step' => 'any']) !!} (segundos)
                                </div>
                            </div>
                            <br/>
                        </div>
                        <div class="col-xs-5">
                            <br/>
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-lg btn-success" value="Salvar">
                                    <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                                </button>
                                <a href="{{ route('sorteios.index') }}" class="btn btn-lg btn-danger">
                                    <i class="glyphicon glyphicon-ban-circle"></i> Cancelar
                                </a>
                            </div>
                        </div>

                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop