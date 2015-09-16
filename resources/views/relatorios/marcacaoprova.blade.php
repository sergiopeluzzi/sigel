@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h2>Relatório - Marcação da Prova</h2>
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

                        {!! Form::open(['route' => 'relatorios.imprimirMarcacaoProva', 'method' => 'post']) !!}

                        

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

        @include('vendor.toast.messages-jquery')

    </div>

@stop