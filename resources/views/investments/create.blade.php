@extends('layouts.app')

@section('title', 'Novo Investimento')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Novo Investimento</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('investments.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome do Investimento</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipo de Investimento</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Selecione o tipo</option>
                                <option value="stocks" {{ old('type') == 'stocks' ? 'selected' : '' }}>Ações</option>
                                <option value="funds" {{ old('type') == 'funds' ? 'selected' : '' }}>Fundos de Investimento</option>
                                <option value="treasury" {{ old('type') == 'treasury' ? 'selected' : '' }}>Tesouro Direto</option>
                                <option value="fixed_income" {{ old('type') == 'fixed_income' ? 'selected' : '' }}>Renda Fixa</option>
                                <option value="crypto" {{ old('type') == 'crypto' ? 'selected' : '' }}>Criptomoedas</option>
                                <option value="others" {{ old('type') == 'others' ? 'selected' : '' }}>Outros</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="investment_date" class="form-label">Data do Investimento</label>
                            <input type="date" class="form-control @error('investment_date') is-invalid @enderror" id="investment_date" name="investment_date" value="{{ old('investment_date') }}" required>
                            @error('investment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="initial_amount" class="form-label">Valor Inicial (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('initial_amount') is-invalid @enderror" id="initial_amount" name="initial_amount" value="{{ old('initial_amount') }}" required>
                            @error('initial_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="current_value" class="form-label">Valor Atual (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('current_value') is-invalid @enderror" id="current_value" name="current_value" value="{{ old('current_value') }}" required>
                            @error('current_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expected_return" class="form-label">Retorno Esperado (% ao ano)</label>
                            <input type="number" step="0.01" class="form-control @error('expected_return') is-invalid @enderror" id="expected_return" name="expected_return" value="{{ old('expected_return') }}">
                            @error('expected_return')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Selecione o status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                                <option value="redeemed" {{ old('status') == 'redeemed' ? 'selected' : '' }}>Resgatado</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('investments.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection