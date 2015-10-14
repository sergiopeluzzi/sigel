@extends('template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-11">
                <div class="panel bg-gray">
                    <div class="panel-heading">
                        <h3>Selecione o Evento</h3>
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
                        {!! Form::open(['method' => 'get']) !!}
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
                                <button type="submit" class="btn btn-lg btn-success" value="Processar" formaction="{{ route('inscricoes.inscricoes') }}">
                                    <i class="glyphicon glyphicon-refresh"></i> Selecionar Evento
                                </button>

                            </div>
                        </div>
                        {!! Form::close() !!}
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
