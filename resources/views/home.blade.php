@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="summary-box income-box">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Receitas</h6>
                    <h3 class="text-success">R$ 3.500,00</h3>
                </div>
                <i class="bi bi-arrow-up-circle fs-1 text-success"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="summary-box expense-box">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Despesas</h6>
                    <h3 class="text-danger">R$ 2.100,00</h3>
                </div>
                <i class="bi bi-arrow-down-circle fs-1 text-danger"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="summary-box balance-box">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Saldo</h6>
                    <h3 class="text-primary">R$ 1.400,00</h3>
                </div>
                <i class="bi bi-wallet2 fs-1 text-primary"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card card-dashboard">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Desempenho Financeiro</h5>
            </div>
            <div class="card-body">
                <canvas id="financialChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-dashboard">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Distribuição por Categoria</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Últimas Transações</h5>
                
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @for($i = 0; $i < 5; $i++)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Compra no Supermercado</h6>
                            <small class="text-muted">Alimentação • 15/05/2024</small>
                        </div>
                        <span class="text-danger">-R$ 150,00</span>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Metas Financeiras</h5>
               
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @for($i = 0; $i < 3; $i++)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Viagem de Férias</h6>
                            <span class="badge bg-success">70%</span>
                        </div>
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>R$ 2.100,00 de R$ 3.000,00</small>
                            <small class="text-muted">Faltam 3 meses</small>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection