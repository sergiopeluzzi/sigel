@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h4>Detalhes do Evento: <b>{{ $evento->id . ': ' . $evento->nome }}</b></h4>
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
                        <table class="table table-hover">
                            <thead class="bg-green-gradient">
                                <th class="col-md-5 text-center">Campo</th>
                                <th class="text-center">Valor</th>
                            </thead>
                            <tbody class="bg-white">
                                <tr>
                                    <td>Nome:</td>
                                    <td>{{ $evento->nome }}</td>
                                </tr>
                                <tr>
                                    <td>Descrição:</td>
                                    <td>{{ $evento->descricao }}</td>
                                </tr>
                                <tr>
                                    <td>Cidade:</td>
                                    <td>{{ $evento->cidade }}</td>
                                </tr>
                                <tr>
                                    <td>Data Início:</td>
                                    <td>{{ $evento->datainicio->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Data Fim:</td>
                                    <td>{{ $evento->datafim->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Número máximo de inscrições:</td>
                                    <td>{{ $evento->maxnuminscricoes }}</td>
                                </tr>
                                <tr>
                                    <td>Número máximo de inscrições por pessoa:</td>
                                    <td>{{ $evento->maxnuminscricoesporpessoa }}</td>
                                </tr>
                                <tr>
                                    <td>Número máximo de inscrições por handcap:</td>
                                    <td>{{ $evento->maxnuminscricoesporhandcap }}</td>
                                </tr>
                                <tr>
                                    <td>Número máximo de inscrições com o mesmo parceiro:</td>
                                    <td>{{ $evento->maxnuminscricoescommesmocompetidor }}</td>
                                </tr>
                                <tr>
                                    <td>Número de provas/bois:</td>
                                    <td>{{ $evento->qntdebois }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="form-group">
                            <a href="{{ route('eventos.edit', ['id' => $evento->id]) }}" class="btn btn-lg btn-primary">
                                <i class="glyphicon glyphicon-edit"></i> Editar
                            </a>
                            <a href="{{ route('eventos.index') }}" class="btn btn-lg btn-danger">
                                <i class="glyphicon glyphicon-ban-circle"></i> Cancelar
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
