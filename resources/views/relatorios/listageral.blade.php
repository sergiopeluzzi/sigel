@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h2>Relatório - Lista Geral</h2>
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

                        {!! Form::open(['route' => 'relatorios.imprimirListaGeral', 'method' => 'post']) !!}
                            <div class="row">
                                <div class="col-xs-6">
                                    <label for="idevento">Ordenar por:</label>
                                    <select id="order" name="order" class="form-control">
                                        <option value="id">Id</option>
                                        <option value="nome">Nome</option>
                                        <option value="apelido">Apelido</option>
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