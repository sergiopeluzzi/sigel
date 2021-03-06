@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h2>Relatório - Ficha do Competidor</h2>
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

                        {!! Form::open(['route' => 'relatorios.imprimirFicha', 'method' => 'post']) !!}
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
                        <br/>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label for="idevento">Competidor:</label>
                                    <select id="idcompetidor" name="idcompetidor" class="form-control">
                                        @foreach($competidores as $competidor)
                                            <option value="{{ $competidor->id }}">{{ $competidor->id . ' - ' . $competidor->nome . ' * ' . $competidor->apelido}}</option>
                                        @endforeach
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

@section('scripts')
    <script type="text/javascript">
        $('select').select2();
    </script>
@stop