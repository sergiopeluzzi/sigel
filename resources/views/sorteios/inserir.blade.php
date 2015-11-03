@extends('template')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    {!! Form::open(['route' => 'sorteios.salvar', 'method' => 'post']) !!}
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

                        <div class="col-xs-12">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-green-gradient">
                                    <tr>
                                        @for($i = 1; $i <= $evento->qntdebois; $i++)
                                            <th>Boi {{$i}}</th>
                                        @endfor
                                        <th>Boi Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        {!! Form::hidden('idinscricao', $inscricao->id) !!}
                                        {!! Form::hidden('idevento', $evento->id) !!}
                                        @for($i = 1; $i <= $evento->qntdebois; $i++)
                                            @if(isset(\App\Prova::where('idinscricao', $inscricao->id)->where('boi', 'boi'.$i)->first()->pontuacao))
                                                <td>{!! Form::text('boi'.$i, \App\Prova::where('idinscricao', $inscricao->id)->where('boi', 'boi'.$i)->first()->pontuacao, ['class' => 'form-control', 'readonly']) !!} </td>
                                            @else
                                                <td>{!! Form::text('boi'.$i, '', ['class' => 'form-control']) !!} </td>
                                            @endif
                                        @endfor
                                        @if(isset(\App\Prova::where('idinscricao', $inscricao->id)->where('boi', 'boifinal')->first()->pontuacao))
                                            <td>{!! Form::text('boifinal', \App\Prova::where('idinscricao', $inscricao->id)->where('boi', 'boifinal')->first()->pontuacao, ['class' => 'form-control', 'readonly']) !!}</td>
                                        @else
                                            <td>{!! Form::text('boifinal', null, ['class' => 'form-control']) !!}</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
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


                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop