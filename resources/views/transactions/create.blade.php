@extends('layouts.app')

@section('title', isset($transaction) ? 'Editar Transação' : 'Nova Transação')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ isset($transaction) ? 'Editar Transação' : 'Nova Transação' }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($transaction) ? route('transactions.update', $transaction->id) : route('transactions.store') }}" method="POST">
                    @csrf
                    @if(isset($transaction))
                        @method('PUT')
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description', $transaction->description ?? '') }}" required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $transaction->amount ?? '') }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Data</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', isset($transaction) ? $transaction->date->format('Y-m-d') : date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Selecione o tipo</option>
                                <option value="income" {{ old('type', $transaction->type ?? (request('type') == 'income' ? 'income' : '')) == 'income' ? 'selected' : '' }}>Receita</option>
                                <option value="expense" {{ old('type', $transaction->type ?? (request('type') == 'expense' ? 'expense' : '')) == 'expense' ? 'selected' : '' }}>Despesa</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->type == 'income' ? 'Receita' : 'Despesa' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Observações</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $transaction->notes ?? '') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
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
        const typeSelect = document.getElementById('type');
        const categorySelect = document.getElementById('category_id');
        
        function filterCategories() {
            const type = typeSelect.value;
            const options = categorySelect.options;
            
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.value === '') continue;
                
                const categoryType = option.text.includes('Receita') ? 'income' : 'expense';
                option.style.display = (type === '' || categoryType === type) ? '' : 'none';
            }
            
            if (categorySelect.value && categorySelect.options[categorySelect.selectedIndex].style.display === 'none') {
                for (let i = 0; i < options.length; i++) {
                    if (options[i].style.display !== 'none' && options[i].value !== '') {
                        categorySelect.value = options[i].value;
                        break;
                    }
                }
            }
        }
        
        typeSelect.addEventListener('change', filterCategories);
        
        filterCategories();
    });
</script>
@endpush
@endsection