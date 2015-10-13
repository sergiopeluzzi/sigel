<div class="form-group">
    {!! Form::label('nome', 'Nome:') !!}
    {!! Form::text('nome', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('descricao', 'Descrição:') !!}
    {!! Form::textArea('descricao', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cidade', 'Cidade:') !!}
    {!! Form::text('cidade', null, ['class' => 'form-control']) !!}
</div>

<div class="row">
    <div class="col-xs-6">
        {!! Form::label('datainicio', 'Data Inicial') !!}
        {!! Form::input('date', 'datainicio', isset($evento) ? $evento->datainicio->format('Y-m-d') : '', ['class' => 'form-control']) !!}
    </div>

    <div class="col-xs-6">
        {!! Form::label('datafim', 'Data Final') !!}
        {!! Form::input('date', 'datafim', isset($evento) ? $evento->datafim->format('Y-m-d') : '', ['class' => 'form-control']) !!}
    </div>

</div>

<br/>

<div class="row">
    <div class="col-xs-3">
        {!! Form::label('valor', 'Valor (R$)') !!}
        {!! Form::input('number', 'valor', null, ['class' => 'form-control', 'step' => 'any']) !!}
    </div>

    <div class="col-xs-3">
        {!! Form::label('valorComDesconto', 'Valor com desconto (R$)') !!}
        {!! Form::input('number', 'valorComDesconto', null, ['class' => 'form-control', 'step' => 'any']) !!}
    </div>

    <div class="col-xs-3">
        {!! Form::label('qntInscricoesComDesconto', 'Qnt de Inscrições com desconto') !!}
        {!! Form::input('number', 'qntInscricoesComDesconto', null, ['class' => 'form-control']) !!}
    </div>
</div>

<br/>

<div class="row">
    <div class="col-xs-3">
        {!! Form::label('maxnuminscricoes', 'Max Inscrições:*') !!}
        {!! Form::input('number', 'maxnuminscricoes', null,
        ['class' => 'form-control',
        'data-toggle' => 'popover',
        'data-trigger' => 'focus',
        'data-placement' => 'top',
        'data-content' => 'Número máximo de inscrições no evento']) !!}
    </div>

    <div class="col-xs-3">
        {!! Form::label('maxnuminscricoesporpessoa', 'Max Inscrições por pessoa:*') !!}
        {!! Form::input('number', 'maxnuminscricoesporpessoa', null,
        ['class' => 'form-control',
        'data-toggle' => 'popover',
        'data-trigger' => 'focus',
        'data-placement' => 'top',
        'data-content' => 'Número máximo de inscrições por pessoa']) !!}
    </div>

    <div class="col-xs-3">
        {!! Form::label('maxnuminscricoesporhandcap', 'Max Inscrições por handcap:*') !!}
        {!! Form::input('number', 'maxnuminscricoesporhandcap', null,
        ['class' => 'form-control',
        'data-toggle' => 'popover',
        'data-trigger' => 'focus',
        'data-placement' => 'top',
        'data-content' => 'Número máximo de inscrições por handcap']) !!}
    </div>

    <div class="col-xs-3">
        {!! Form::label('maxnuminscricoescommesmocompetidor', 'Max Inscrições por parceiro:*') !!}
        {!! Form::input('number', 'maxnuminscricoescommesmocompetidor', null,
        ['class' => 'form-control',
        'data-toggle' => 'popover',
        'data-trigger' => 'focus',
        'data-placement' => 'top',
        'data-content' => 'Número máximo de inscrições do competidor com o mesmo parceiro']) !!}
    </div>
</div>
<p class="text-red pull-right"><b>*Insira 0 (zero) para ilimitado</b></p>
<br/>
<div class="row">
    <div class="col-xs-3">
        {!! Form::label('qntdebois', 'Quantidade de provas') !!}
        {!! Form::input('number', 'qntdebois', null,
        ['class' => 'form-control',
        'data-toggle' => 'popover',
        'data-trigger' => 'focus',
        'data-placement' => 'top',
        'data-content' => 'Quantidade provas/bois antes da prova/boi final']) !!}
    </div>
    <div class="col-xs-3">
        {!! Form::label('pulaquantos', 'Distância de corrida') !!}
        {!! Form::input('number', 'pulaquantos', null,
        ['class' => 'form-control',
        'data-toggle' => 'popover',
        'data-trigger' => 'focus',
        'data-placement' => 'top',
        'data-content' => 'Diferença entre uma corrida e outra da mesma inscrição']) !!}
    </div>
</div>
<br>