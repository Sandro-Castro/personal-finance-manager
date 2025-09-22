@extends('layouts.app')

@section('title', isset($category) ? 'Editar Categoria' : 'Nova Categoria')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ isset($category) ? 'Editar Categoria' : 'Nova Categoria' }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Selecione o tipo</option>
                            <option value="income" {{ old('type', $category->type ?? '') == 'income' ? 'selected' : '' }}>Receita</option>
                            <option value="expense" {{ old('type', $category->type ?? '') == 'expense' ? 'selected' : '' }}>Despesa</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="color" class="form-label">Cor</label>
                        <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color', $category->color ?? '#3B71CA') }}" required>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="icon" class="form-label">Ícone</label>
                        <select class="form-select @error('icon') is-invalid @enderror" id="icon" name="icon" required>
                            <option value="">Selecione um ícone</option>
                            <option value="💰" {{ old('icon', $category->icon ?? '') == '💰' ? 'selected' : '' }}>💰 - Dinheiro</option>
                            <option value="💳" {{ old('icon', $category->icon ?? '') == '💳' ? 'selected' : '' }}>💳 - Cartão</option>
                            <option value="🍔" {{ old('icon', $category->icon ?? '') == '🍔' ? 'selected' : '' }}>🍔 - Comida</option>
                            <option value="🏠" {{ old('icon', $category->icon ?? '') == '🏠' ? 'selected' : '' }}>🏠 - Casa</option>
                            <option value="🚗" {{ old('icon', $category->icon ?? '') == '🚗' ? 'selected' : '' }}>🚗 - Transporte</option>
                            <option value="🎮" {{ old('icon', $category->icon ?? '') == '🎮' ? 'selected' : '' }}>🎮 - Entretenimento</option>
                            <option value="💊" {{ old('icon', $category->icon ?? '') == '💊' ? 'selected' : '' }}>💊 - Saúde</option>
                            <option value="👕" {{ old('icon', $category->icon ?? '') == '👕' ? 'selected' : '' }}>👕 - Vestuário</option>
                        </select>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection