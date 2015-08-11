<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left text-white text-center">
                <p>Olá, <b>{{ Auth::user()->name }}</b></p>
                <i class="fa fa-circle text-success"></i> Online
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="header">CADASTROS</li>
            <li @if($titPagina == 'Competidores') class="active" @endif><a href="/competidores"><span>Competidores</span></a></li>
            <li @if($titPagina == 'Eventos') class="active" @endif><a href="/eventos"><span>Eventos</span></a></li>
            <li class="header">INSCRIÇÕES</li>
            <li @if($titPagina == 'Inscrições') class="active" @endif><a href="/inscricoes"><span>Fazer Inscrição</span></a></li>
            <li @if($titPagina == 'Sorteios') class="active" @endif><a href="/sorteios"><span>Gerar Sorteio</span></a></li>
        </ul>
    </section>
</aside>