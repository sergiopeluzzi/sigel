@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <a class="btn btn-lg btn-success" href="{{ route('eventos.create') }}"><i class="glyphicon glyphicon-plus"></i> Adicionar</a>
                    </div>
                    <div class="panel-body">
                        <table id="tbeventos" class="table table-hover" cellspacing="0" width="100%">
                            <thead class="bg-green-gradient text-nowrap">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Cidade</th>
                                <th class="text-center">Início</th>
                                <th class="text-center">Fim</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($eventos as $evento)
                                <tr>
                                    <td class="text-center">{{ $evento->id }}</td>
                                    <td class="text-nowrap">{{ $evento->nome }}</td>
                                    <td>{{ $evento->descricao }}</td>
                                    <td class="text-nowrap">{{ $evento->cidade }}</td>
                                    <td class="text-center text-nowrap">{{ $evento->datainicio->format('d/m/Y') }}</td>
                                    <td class="text-center text-nowrap">{{ $evento->datafim->format('d/m/Y') }}</td>
                                    <td align="center" class="text-nowrap">
                                        <a data-toggle="tooltip" data-original-title="Detalhes" class="btn btn-sm btn-warning" href="{{ route('eventos.show', ['id' => $evento->id]) }}"><i class="glyphicon glyphicon-book"></i></a>
                                        <a data-toggle="tooltip" data-original-title="Editar" class="btn btn-sm btn-primary" href="{{ route('eventos.edit', ['id' => $evento->id]) }}"><i class="glyphicon glyphicon-edit"></i></a>
                                        <a data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger" href="#" data-href="{{ route('eventos.destroy', ['id' => $evento->id]) }}"><i class="glyphicon glyphicon-remove"></i></a>
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
                        Tem certeza que deseja excluir este evento?
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
            $('#tbeventos').DataTable();
        } );
    </script>

@stop
