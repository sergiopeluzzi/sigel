@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h4>Adicionar novo Evento</h4>
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
                        {!! Form::open(['route' => 'eventos.store', 'method' => 'post']) !!}

                        @include('eventos.form')

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success" value="Salvar">
                                <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                            </button>
                            <a href="{{ route('eventos.index') }}" class="btn btn-lg btn-danger">
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
    <!-- Script q formata os hints -->
    <script type="text/javascript">
        $("#maxnuminscricoes").popover();
        $("#maxnuminscricoesporpessoa").popover();
        $("#maxnuminscricoesporhandcap").popover();
        $("#maxnuminscricoescommesmocompetidor").popover();
        $("#qntdebois").popover();
        $("#pulaquantos").popover();
    </script>
@stop