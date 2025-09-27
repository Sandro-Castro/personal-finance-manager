@extends('layouts.app')

@section('title', isset($goal) ? 'Editar Meta' : 'Nova Meta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ isset($goal) ? 'Editar Meta' : 'Nova Meta' }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($goal) ? route('goals.update', $goal->id) : route('goals.store') }}" method="POST">
                    @csrf
                    @if(isset($goal))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome da Meta</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $goal->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="target_amount" class="form-label">Valor Alvo (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('target_amount') is-invalid @enderror" id="target_amount" name="target_amount" value="{{ old('target_amount', $goal->target_amount ?? '') }}" required>
                            @error('target_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="current_amount" class="form-label">Valor Atual (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('current_amount') is-invalid @enderror" id="current_amount" name="current_amount" value="{{ old('current_amount', $goal->current_amount ?? '') }}" required>
                            @error('current_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label">Prazo</label>
                            <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline', isset($goal) ? $goal->deadline->format('Y-m-d') : '') }}" required>
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Selecione o status</option>
                                <option value="in_progress" {{ old('status', $goal->status ?? '') == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                                <option value="completed" {{ old('status', $goal->status ?? '') == 'completed' ? 'selected' : '' }}>Concluída</option>
                                <option value="cancelled" {{ old('status', $goal->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categoria (Opcional)</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            <option value="">Selecione uma categoria (opcional)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $goal->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->type == 'income' ? 'Receita' : 'Despesa' }})
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $goal->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('goals.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetAmount = document.getElementById('target_amount');
        const currentAmount = document.getElementById('current_amount');
        
        function calculateProgress() {
            const target = parseFloat(targetAmount.value) || 0;
            const current = parseFloat(currentAmount.value) || 0;
            
            if (target > 0) {
                const progress = (current / target) * 100;
                console.log('Progresso:', progress.toFixed(2) + '%');
            }
        }
        
        targetAmount.addEventListener('input', calculateProgress);
        currentAmount.addEventListener('input', calculateProgress);
    });
</script>
@endpush
@endsection