@extends('layouts.app')

@section('title', 'Metas Financeiras')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('goals.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nova Meta
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('goals.search') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Buscar metas..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($goals->count() > 0)
            <div class="row">
                @foreach($goals as $goal)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title">{{ $goal->name }}</h5>
                                <span class="badge 
                                    @if($goal->status == 'completed') bg-success
                                    @elseif($goal->status == 'cancelled') bg-secondary
                                    @else bg-primary @endif">
                                    @if($goal->status == 'completed') Concluída
                                    @elseif($goal->status == 'cancelled') Cancelada
                                    @else Em Andamento @endif
                                </span>
                            </div>
                            
                            <p class="card-text">{{ $goal->description }}</p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Progresso</span>
                                    <span>{{ number_format(($goal->current_amount / $goal->target_amount) * 100, 0) }}%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar 
                                        @if($goal->status == 'completed') bg-success
                                        @elseif($goal->status == 'cancelled') bg-secondary
                                        @else @endif" 
                                        role="progressbar" 
                                        style="width: {{ ($goal->current_amount / $goal->target_amount) * 100 }}%;" 
                                        aria-valuenow="{{ ($goal->current_amount / $goal->target_amount) * 100 }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small>R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</small>
                                    <small>R$ {{ number_format($goal->target_amount, 2, ',', '.') }}</small>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between text-muted small">
                                <div>
                                    <i class="bi bi-calendar"></i> 
                                    Prazo: {{ $goal->deadline->format('d/m/Y') }}
                                </div>
                                <div>
                                    @if ($goal->days_remaining < 0)
                                        <span class="text-success">Faltam {{ abs($goal->days_remaining) }} dias</span>
                                    @elseif ($goal->days_remaining === 0)
                                        <span class="text-warning">Vence hoje</span>
                                    @else
                                        <span class="text-danger">Vencida há {{ $goal->days_remaining }} dias</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('goals.edit', $goal->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta meta?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Paginação -->
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Mostrando {{ $goals->firstItem() }} a {{ $goals->lastItem() }} de {{ $goals->total() }} resultados
                    </div>
                    <div>
                        {{ $goals->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            <!-- <div class="d-flex justify-content-center mt-4">
                {{ $goals->links('pagination::bootstrap-5') }}
            </div> -->
        @else
            <div class="text-center py-5">
                <i class="bi bi-bullseye" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Nenhuma meta encontrada</h4>
                <p class="text-muted">Comece criando sua primeira meta financeira</p>
                <a href="{{ route('goals.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Criar Meta
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
