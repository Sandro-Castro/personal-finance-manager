@extends('layouts.app')

@section('title', 'Transações')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Transações</h2>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-plus-circle"></i> Nova Transação
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="{{ route('transactions.create', ['type' => 'income']) }}">Receita</a></li>
            <li><a class="dropdown-item" href="{{ route('transactions.create', ['type' => 'expense']) }}">Despesa</a></li>
        </ul>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('transactions.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control form-control-sm" id="search" name="search" placeholder="Descrição ou categoria..." value="{{ request('search') }}">
            </div>
            
            <div class="col-md-2">
                <label for="type" class="form-label">Tipo</label>
                <select class="form-select form-select-sm" id="type" name="type">
                    <option value="">Todos</option>
                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Receita</option>
                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Despesa</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="category_id" class="form-label">Categoria</label>
                <select class="form-select form-select-sm" id="category_id" name="category_id">
                    <option value="">Todas</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="start_date" class="form-label">Data Inicial</label>
                <input type="date" class="form-control form-control-sm" id="start_date" name="start_date" value="{{ request('start_date') }}">
            </div>
            
            <div class="col-md-2">
                <label for="end_date" class="form-label">Data Final</label>
                <input type="date" class="form-control form-control-sm" id="end_date" name="end_date" value="{{ request('end_date') }}">
            </div>
            
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-filter"></i> Filtrar
                </button>
            </div>
            
            <div class="col-md-1 d-flex align-items-end">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm w-100">
                    <i class="bi bi-x-circle"></i> Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-2">Data</th>
                            <th class="py-2">Descrição</th>
                            <th class="py-2">Categoria</th>
                            <th class="py-2">Tipo</th>
                            <th class="py-2 text-end">Valor</th>
                            <th class="py-2 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td class="py-2">{{ $transaction->date->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $transaction->description }}</td>
                            <td class="py-2">
                                <span class="badge" style="background-color: {{ $transaction->category->color }}; color: white;">
                                    {{ $transaction->category->name }}
                                </span>
                            </td>
                            <td class="py-2">
                                @if($transaction->type == 'income')
                                    <span class="badge bg-success">Receita</span>
                                @else
                                    <span class="badge bg-danger">Despesa</span>
                                @endif
                            </td>
                            <td class="py-2 text-end fw-bold">
                                @if($transaction->type == 'income')
                                    <span class="text-success">R$ {{ number_format($transaction->amount, 2, ',', '.') }}</span>
                                @else
                                    <span class="text-danger">-R$ {{ number_format($transaction->amount, 2, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="py-2 text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm py-1">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary btn-sm py-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm py-1" onclick="return confirm('Tem certeza que deseja excluir esta transação?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Mostrando {{ $transactions->firstItem() }} a {{ $transactions->lastItem() }} de {{ $transactions->total() }} resultados
                    </div>
                    <div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-receipt" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Nenhuma transação encontrada</h4>
                <p class="text-muted">
                    @if(request()->anyFilled(['search', 'type', 'category_id', 'start_date', 'end_date']))
                        Tente ajustar os filtros ou
                    @endif
                    Comece criando sua primeira transação
                </p>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Criar Transação
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        if (!startDate.value) {
            const firstDay = new Date();
            firstDay.setDate(1);
            startDate.value = firstDay.toISOString().split('T')[0];
        }
        
        if (!endDate.value) {
            endDate.value = new Date().toISOString().split('T')[0];
        }
        
        document.querySelectorAll('.pagination .page-link').forEach(link => {
            link.classList.add('btn-sm');
        });
    });
</script>
@endpush