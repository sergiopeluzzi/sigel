@extends('template')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                                <th class="text-center">Ord</th>
                                <th class="text-center">HC Total</th>
                                <th class="text-center" colspan="2">Competidor Cabeça</th>
                                <th class="text-center" colspan="2">Competidor Pé</th>
                                @for($i = 1; $i <= $evento->qntdebois; $i++)
                                    <th class="text-center">Boi {{ $i }}</th>
                                @endfor
                                <th class="text-center">Média</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inscricoes as $inscricao)
                                <tr class="text-nowrap no-margin">
                                    <td class="text-center" width="5">{{ $pos++ }}</td>
                                    <td class="text-center text-bold lead" width="5">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca + \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                                    <td class="text-center" width="15">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca }}</td>
                                    <td>{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorcabeca)->apelido }}</td>
                                    <td class="text-center" width="15">{{ \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                                    <td>{{ \App\Competidor::find($inscricao->idcompetidorpe)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorpe)->apelido }}</td>
                                    @for($i = 1; $i <= $evento->qntdebois; $i++)
                                        <td class="text-center">{{ isset(\App\Prova::where('idinscricao', $inscricao->id)->where('boi', 'boi'.$i)->first()->pontuacao) ? \App\Prova::where('idinscricao', $inscricao->id)->where('boi', 'boi'.$i)->first()->pontuacao : '' }}</td>
                                    @endfor
                                    <td class="text-center text-bold lead">@if($prova->where('idinscricao', $inscricao->id)->sum('pontuacao') == 0) {{ '' }} @else {{ number_format($prova->where('idinscricao', $inscricao->id)->sum('pontuacao') / ($prova->where('idinscricao', $inscricao->id)->count()), 3, ',', '.') }}@endif</td>
                                    <td align="center">
                                        @if(true)
                                            <a data-toggle="tooltip" data-original-title="Inserir tempo" class="btn btn-sm btn-primary" href="{{ route('sorteios.visualizar.inserir', ['id' => $inscricao->id]) }}"><i class="glyphicon glyphicon-time"></i></a>
                                        @else
                                            <a data-toggle="tooltip" data-original-title="Editar tempo" class="btn btn-sm btn-warning" href="{{ route('sorteios.visualizar.editar', ['id' => $inscricao->id]) }}"><i class="glyphicon glyphicon-list-alt"></i></a>
                                        @endif
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

