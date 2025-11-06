@extends('layouts.app')

@section('title', 'Investimentos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Investimentos</h2>
    <a href="{{ route('investments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Investimento
    </a>
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $investments->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-graph-up" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Nenhum investimento encontrado</h4>
                <p class="text-muted">Comece criando seu primeiro investimento</p>
                <a href="{{ route('investments.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Criar Investimento
                </a>
            </div>
        @endif
    </div>
</div>
@endsection