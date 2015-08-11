@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <a class="btn btn-lg btn-success" href="{{ route('competidores.create') }}"><i class="glyphicon glyphicon-plus"></i> Adicionar</a>
                    </div>
                    <div class="panel-body">
                        <table id="tbcompetidores" class="table table-hover text-nowrap" cellspacing="0" width="100%">
                            <thead class="bg-green-gradient">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Cidade</th>
                                <th class="text-center">Apelido</th>
                                <th class="text-center">HC Cabeça</th>
                                <th class="text-center">HC Pés</th>
                                <th class="text-center">Telefone</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($competidores as $competidor)
                                <tr>
                                    <td class="text-center">{{ $competidor->id }}</td>
                                    <td>{{ $competidor->nome }}</td>
                                    <td>{{ $competidor->cidade }}</td>
                                    <td>{{ $competidor->apelido }}</td>
                                    <td class="text-center">{{ $competidor->handcapcabeca }}</td>
                                    <td class="text-center">{{ $competidor->handcappe }}</td>
                                    <td class="text-center">{{ $competidor->telefone }}</td>
                                    <td>
                                        <a data-toggle="tooltip" data-original-title="Editar" class="btn btn-sm btn-primary" href="{{ route('competidores.edit', ['id' => $competidor->id]) }}"><i class="glyphicon glyphicon-edit"></i></a>
                                        <a data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger" href="#" data-href="{{ route('competidores.destroy', ['id' => $competidor->id]) }}"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                        Tem certeza que deseja excluir este competidor?
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
            $('#tbcompetidores').DataTable();
        } );
    </script>

@stop
