@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">

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
                        {!! Form::open(['route' => 'inscricoes.inscrever', 'method' => 'post']) !!}
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
                                    <label for="idcompetidorcabeca">Competidor Cabeça:</label>
                                    <select id="idcompetidorcabeca" name="idcompetidorcabeca" class="form-control">
                                        @foreach($competidores as $competidor)
                                            <option value="{{ $competidor->id }}">{{ $competidor->id . ' - ' . $competidor->nome . ' * ' . $competidor->apelido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <label for="idcompetidorpe">Competidor Pé:</label>
                                    <select id="idcompetidorpe" name="idcompetidorpe" class="form-control">
                                        @foreach($competidores as $competidor)
                                            <option value="{{ $competidor->id }}">{{ $competidor->id . ' - ' . $competidor->nome . ' * ' . $competidor->apelido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label for="qntdeinscricoes">N. Inscrições:</label>
                                    <select id="qntdeinscricoes" name="qntdeinscricoes" class="form-control">
                                        @for($i = 1; $i <= 50; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-lg btn-success" value="Salvar">
                                        <i class="glyphicon glyphicon-pencil"></i> Inscrever
                                    </button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <br/>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="tbinscricoes" class="table table-hover text-nowrap" cellspacing="0" width="100%">
                                    <thead class="bg-green-gradient">
                                    <tr>
                                        <th class="text-center">Inscrição</th>
                                        <th class="text-center">Evento</th>
                                        <th class="text-center">Competidor Cabeça</th>
                                        <th class="text-center">Competidor Pé</th>
                                        <th class="text-center">Handcap Total</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inscricoes as $inscricao)
                                        <tr>
                                            <td class="text-center">{{ $inscricao->id }}</td>
                                            <td>{{ $inscricao->idevento . ' - ' . \App\Evento::find($inscricao->idevento)->nome }}</td>
                                            <td>{{ $inscricao->idcompetidorcabeca . ' - ' . \App\Competidor::find($inscricao->idcompetidorcabeca)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorcabeca)->apelido }}</td>
                                            <td>{{ $inscricao->idcompetidorpe . ' - ' . \App\Competidor::find($inscricao->idcompetidorpe)->nome . ' * ' . \App\Competidor::find($inscricao->idcompetidorpe)->apelido }}</td>
                                            <td class="text-center">{{ \App\Competidor::find($inscricao->idcompetidorcabeca)->handcapcabeca + \App\Competidor::find($inscricao->idcompetidorpe)->handcappe }}</td>
                                            <td align="center">
                                                <a data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger" href="#" data-href="{{ route('inscricoes.destroy', ['id' => $inscricao->id]) }}"><i class="glyphicon glyphicon-remove"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-danger fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h3>Confirmação de Exclusão</h3>
                    </div>
                    <div class="modal-body text-center">
                        Tem certeza que deseja excluir esta inscrição?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">NÃO</button>
                        <a class="btn btn-danger btn-ok">SIM</a>
                    </div>
                </div>
            </div>
        </div>

        @include('vendor.toast.messages-jquery')

    </div>
@stop

@section('scripts')

    <!-- Script q atribui ao href a registro a ser deletado em questão -->
    <script language="JavaScript" type="text/javascript">
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>

    <!-- Script q inicia a DataTable na table em questão -->
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function() {
            $('#tbinscricoes').DataTable();
        } );
    </script>

    <script type="text/javascript">
        $('select').select2();
    </script>
@stop
