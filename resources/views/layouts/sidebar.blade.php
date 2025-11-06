<div class="col-md-3 col-lg-2 sidebar bg-white">
    <div class="position-sticky pt-3">
        <div class="text-center my-4">
            <h4 class="text-primary">
                <i class="bi bi-wallet2"></i> FinanceManager
            </h4>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ url('/home') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}" href="{{ url('/transactions') }}">
                    <i class="bi bi-arrow-left-right me-2"></i> Transações
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('categories*') ? 'active' : '' }}" href="{{ url('/categories') }}">
                    <i class="bi bi-tag me-2"></i> Categorias
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('goals*') ? 'active' : '' }}" href="{{ url('/goals') }}">
                    <i class="bi bi-bullseye me-2"></i> Metas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('reports*') ? 'active' : '' }}" href="{{ url('/reports') }}">
                    <i class="bi bi-bar-chart me-2"></i> Relatórios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('investments*') ? 'active' : '' }}" href="{{ route('investments.index') }}">
                    <i class="bi bi-graph-up me-2"></i> Investimentos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('receipts*') ? 'active' : '' }}" href="{{ route('receipts.index') }}">
                    <i class="bi bi-receipt me-2"></i> Comprovantes
                </a>
            </li>
        </ul>

        <hr>

        <div class="dropdown my-4">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser"
                data-bs-toggle="dropdown" aria-expanded="false">
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="User" width="32" height="32" class="rounded-circle me-2">
                @else
                    <img src="https://avatar.iran.liara.run/public" alt="User" width="32" height="32" class="rounded-circle me-2">
                @endif
                <strong>{{ Auth::check() ? Auth::user()->name : 'Visitante' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Editar Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>