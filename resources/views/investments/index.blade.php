@extends('layouts.app')

@section('title', 'Investimentos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Investimentos</h2>
    <a href="{{ route('investments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Investimento
    </a>
</div>

<!-- Formulário de Busca -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('investments.search') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Buscar investimentos por nome, descrição ou tipo..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
        @if(request('search'))
            <div class="mt-2">
                <a href="{{ route('investments.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Limpar busca
                </a>
                <span class="text-muted ms-2">Resultados para: "{{ request('search') }}"</span>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($investments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Valor Inicial</th>
                            <th>Valor Atual</th>
                            <th>Retorno</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investments as $investment)
                        <tr>
                            <td>{{ $investment->name }}</td>
                            <td>{{ $investment->type_formatted }}</td>
                            <td>R$ {{ number_format($investment->initial_amount, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($investment->current_value, 2, ',', '.') }}</td>
                            <td>
                                <span class="{{ $investment->return_amount >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($investment->current_return, 2) }}%
                                    (R$ {{ number_format($investment->return_amount, 2, ',', '.') }})
                                </span>
                            </td>
                            <td>
                                @if($investment->status == 'active')
                                    <span class="badge bg-success">Ativo</span>
                                @elseif($investment->status == 'redeemed')
                                    <span class="badge bg-info">Resgatado</span>
                                @else
                                    <span class="badge bg-secondary">Cancelado</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('investments.show', $investment->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('investments.edit', $investment->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('investments.destroy', $investment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este investimento?')">
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
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Mostrando {{ $investments->firstItem() }} a {{ $investments->lastItem() }} de {{ $investments->total() }} resultados
                </div>
                <div>
                    {{ $investments->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-graph-up" style="font-size: 3rem;"></i>
                <h4 class="mt-3">
                    @if(request('search'))
                        Nenhum investimento encontrado para "{{ request('search') }}"
                    @else
                        Nenhum investimento encontrado
                    @endif
                </h4>
                <p class="text-muted">
                    @if(request('search'))
                        Tente ajustar os termos da busca ou
                    @endif
                    Comece criando seu primeiro investimento
                </p>
                <a href="{{ route('investments.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Criar Investimento
                </a>
                @if(request('search'))
                    <a href="{{ route('investments.index') }}" class="btn btn-outline-secondary mt-2 ms-2">
                        <i class="bi bi-arrow-left"></i> Ver todos os investimentos
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection