@extends('template')

@section('content')
    @foreach($menu as $col)
        <div class="col-xs-4">
            <div class="box box-solid box-success">
                <div class="box-header text-center">
                    <h1>{{ $col['nome'] }}</h1>
                </div>
                <div class="box-body">
                    <p>{{ $col['descricao'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
@stop