@extends('template')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h3>Selecione o Evento e clique na função desejada!</h3>
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
                        {!! Form::open(['method' => 'post']) !!}
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
                                <div class="container">
                                    <button type="submit" class="btn btn-lg btn-success" value="Processar" formaction="{{ route('sorteios.processar') }}">
                                        <i class="glyphicon glyphicon-refresh"></i> Processar Sorteio
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-danger" value="Deletar" formaction="{{ route('sorteios.deletar') }}">
                                        <i class="glyphicon glyphicon-erase"></i> Apagar Sorteio
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-info" value="Visualizar" formaction="{{ route('sorteios.visualizar') }}">
                                        <i class="glyphicon glyphicon-th"></i> Visualizar Prova
                                    </button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        @include('vendor.toast.messages-jquery')

    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $('select').select2();
    </script>
@stop

