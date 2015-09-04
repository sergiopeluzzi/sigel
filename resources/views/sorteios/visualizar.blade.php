@extends('template')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h2>{{ $evento->id . ' - ' .$evento->nome }}</h2>
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
                        {!! Form::model($prova, ['route' => ['sorteios.salvar', $prova->id], 'method' => 'put']) !!}
                        <table id="tbprova" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead class="bg-green-gradient">
                            <tr>
                                <th class="text-center">HC Total</th>
                                <th class="text-center" colspan="2">Competidor Cabeça</th>
                                <th class="text-center" colspan="2">Competidor Pé</th>
                                @for($i = 1; $i <= $evento->qntdebois; $i++)
                                    <th class="text-center">Boi {{$i}}</th>
                                @endfor
                                <th class="text-center">Boi Final</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inscricoes as $inscricao)
                                <tr>
                                    {!! Form::hidden('idinscricao', $inscricao->id) !!}
                                    <td class="text-center text-bold" width="5">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca + \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                                    <td class="text-center" width="5">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca }}</td>
                                    <td>{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->nome }} <br/> {{'* ' . \App\Competidor::find($inscricao->idcompetidorcabeca)->apelido }}</td>
                                    <td class="text-center" width="5">{{ \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                                    <td>{{ \App\Competidor::find($inscricao->idcompetidorpe)->nome }} <br> {{'* ' . \App\Competidor::find($inscricao->idcompetidorpe)->apelido }}</td>
                                    @for($i = 1; $i <= $evento->qntdebois; $i++)
                                        <td class="text-center">{!! Form::text("boi$i",  null, ['class' => 'form-control']) !!}</td>
                                    @endfor
                                    <td class="text-center">{!! Form::text("boifinal",  null, ['class' => 'form-control']) !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-lg btn-success" value="Salvar">
                            <i class="glyphicon glyphicon-floppy-save"></i> Salvar
                        </button>
                        {!! Form::hidden('idevento', $evento->id) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        @include('vendor.toast.messages-jquery')

    </div>
@stop

@section('scripts')
    <!-- Script q inicia a DataTable na table em questão -->
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function() {
            $('#tbprova').DataTable();
        } );
    </script>
@stop

