@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h4>Editar competidor: <b>{{ $competidor->id . ': ' . $competidor->nome }} </b></h4>
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
                        {!! Form::model($competidor, ['route' => ['competidores.update', $competidor->id], 'method' => 'put']) !!}

                        @include('competidores.form')

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success" value="Salvar">
                                <i class="glyphicon glyphicon-ok"></i> Atualizar
                            </button>
                            <a href="{{ route('competidores.index') }}" class="btn btn-lg btn-danger">
                                <i class="glyphicon glyphicon-ban-circle"></i> Cancelar
                            </a>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <!-- Script q formata o campo telefone -->
    <script type="text/javascript">
        $("#telefone").mask("(99) 9999-9999");
    </script>
@stop