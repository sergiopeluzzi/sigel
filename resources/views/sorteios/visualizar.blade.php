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
                        <table id="tbprova" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead class="bg-green-gradient">
                            <tr>
                                <th class="text-center">HC Total</th>
                                <th class="text-center" colspan="2">Competidor Cabeça</th>
                                <th class="text-center" colspan="2">Competidor Pé</th>
                                <th class="text-center">Média</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inscricoes as $inscricao)
                                <tr class="text-nowrap no-margin">
                                    <td class="text-center text-bold lead" width="5">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca + \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                                    <td class="text-center" width="15">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca }}</td>
                                    <td>{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorcabeca)->apelido }}</td>
                                    <td class="text-center" width="15">{{ \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                                    <td>{{ \App\Competidor::find($inscricao->idcompetidorpe)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorpe)->apelido }}</td>
                                    <td class="text-center text-bold lead">9.8</td>
                                    <td align="center">
                                        <a data-toggle="tooltip" data-original-title="Inserir tempo" class="btn btn-sm btn-primary" href="{{ route('sorteios.visualizar.inserir', ['id' => $inscricao->id]) }}"><i class="glyphicon glyphicon-time"></i></a>
                                        <a data-toggle="tooltip" data-original-title="Editar tempo" class="btn btn-sm btn-warning" href="{{ route('sorteios.visualizar.editar', ['id' => $inscricao->id]) }}"><i class="glyphicon glyphicon-list-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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

