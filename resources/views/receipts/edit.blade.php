@extends('layouts.app')

@section('title', 'Editar Comprovante')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Editar Comprovante</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('receipts.update', $receipt->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Título do Comprovante</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $receipt->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $receipt->amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Data</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $receipt->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Selecione o tipo</option>
                                <option value="income" {{ old('type', $receipt->type) == 'income' ? 'selected' : '' }}>Receita</option>
                                <option value="expense" {{ old('type', $receipt->type) == 'expense' ? 'selected' : '' }}>Despesa</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $receipt->category_id) == $category->id ? 'selected' : '' }}>
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
                        <label for="image" class="form-label">Imagem do Comprovante</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Deixe em branco para manter a imagem atual. Formatos aceitos: JPEG, PNG, JPG, GIF, WEBP. Tamanho máximo: 5MB.</div>
                        
                        @if($receipt->image_path)
                            <div class="mt-2">
                                <img src="{{ Storage::url($receipt->image_path) }}" alt="Comprovante atual" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $receipt->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('receipts.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Filtro de categorias baseado no tipo
    document.getElementById('type').addEventListener('change', function() {
        const type = this.value;
        const categorySelect = document.getElementById('category_id');
        const options = categorySelect.options;
        
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            if (option.value === '') continue;
            
            const categoryType = option.text.includes('Receita') ? 'income' : 'expense';
            option.style.display = (type === '' || categoryType === type) ? '' : 'none';
        }
        
        // Resetar seleção se a categoria atual não for do tipo selecionado
        if (categorySelect.value) {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            if (selectedOption.style.display === 'none') {
                categorySelect.value = '';
            }
        }
    });

    // Disparar o evento change ao carregar a página para filtrar categorias se já houver um tipo selecionado
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        if (typeSelect.value) {
            typeSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection