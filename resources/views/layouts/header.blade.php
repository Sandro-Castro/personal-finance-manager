<header class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">@yield('title', 'Home')</h1>
    
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-download"></i> Exportar
            </button>
        </div>
        
        <div class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-plus-circle"></i> Nova Transação
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                {{--  <li><a class="dropdown-item" href="{{ route('transactions.create', ['type' => 'income']) }}">Receita</a></li>
                <li><a class="dropdown-item" href="{{ route('transactions.create', ['type' => 'expense']) }}">Despesa</a></li>--}}
            </ul>
        </div>
    </div>
</header>