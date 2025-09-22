@extends('layouts.app')

@section('title', 'Início')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Olá, {{ Auth::user()->name }}!</h2>
                    <p class="text-muted mb-0">Aqui está o resumo da sua situação financeira</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Nova Receita
                    </a>
                    <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-plus-circle"></i> Nova Despesa
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <p class="text-muted mb-1">Saldo Total Disponível</p>
                    <h1 class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                        R$ {{ number_format($balance, 2, ',', '.') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Receitas deste Mês</h6>
                    <h3 class="text-success">R$ {{ number_format($currentMonthIncome, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Despesas deste Mês</h6>
                    <h3 class="text-danger">R$ {{ number_format($currentMonthExpense, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Saldo do Mês</h6>
                    <h3 class="{{ $currentMonthBalance >= 0 ? 'text-success' : 'text-danger' }}">
                        R$ {{ number_format($currentMonthBalance, 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Evolução do Mês</h5>
                </div>
                <div class="card-body">
                    <canvas id="miniChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Últimas Transações</h5>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="card-body p-0">
                    @if($recentTransactions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentTransactions as $transaction)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge me-2" style="background-color: {{ $transaction->category->color }}; color: white;">
                                            {{ $transaction->category->icon }}
                                        </span>
                                        <div>
                                            <h6 class="mb-0">{{ $transaction->description }}</h6>
                                            <small class="text-muted">
                                                {{ $transaction->category->name }} • 
                                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m') }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }} fw-bold">
                                        {{ $transaction->type == 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Nenhuma transação recente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Metas em Andamento</h5>
                    <a href="{{ route('goals.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="card-body">
                    @if($activeGoals->count() > 0)
                        @foreach($activeGoals as $goal)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0">{{ $goal->name }}</h6>
                                    <span class="badge bg-primary">
                                        {{ number_format(($goal->current_amount / $goal->target_amount) * 100, 0) }}%
                                    </span>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ ($goal->current_amount / $goal->target_amount) * 100 }}%;" 
                                         aria-valuenow="{{ ($goal->current_amount / $goal->target_amount) * 100 }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</span>
                                    <span>R$ {{ number_format($goal->target_amount, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-bullseye text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Nenhuma meta ativa</p>
                            <a href="{{ route('goals.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="bi bi-plus-circle"></i> Criar Meta
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Atalhos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn btn-success w-100 h-100 py-3">
                                <i class="bi bi-arrow-down-circle fs-1 d-block mb-2"></i>
                                Nova Receita
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="btn btn-danger w-100 h-100 py-3">
                                <i class="bi bi-arrow-up-circle fs-1 d-block mb-2"></i>
                                Nova Despesa
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('goals.create') }}" class="btn btn-primary w-100 h-100 py-3">
                                <i class="bi bi-bullseye fs-1 d-block mb-2"></i>
                                Nova Meta
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('reports.index') }}" class="btn btn-info w-100 h-100 py-3">
                                <i class="bi bi-bar-chart fs-1 d-block mb-2"></i>
                                Ver Relatórios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const miniCtx = document.getElementById('miniChart').getContext('2d');
        const miniChart = new Chart(miniCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($dailyBalance)) !!},
                datasets: [{
                    label: 'Saldo Diário',
                    data: {!! json_encode(array_values($dailyBalance)) !!},
                    borderColor: '#3B71CA',
                    backgroundColor: 'rgba(59, 113, 202, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#3B71CA',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Dia do Mês'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Saldo (R$)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 0});
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush