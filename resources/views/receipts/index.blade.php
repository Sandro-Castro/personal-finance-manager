@extends('layouts.app')

@section('title', 'Comprovantes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Comprovantes</h2>
    <a href="{{ route('receipts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Comprovante
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('receipts.search') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Buscar comprovantes por título, descrição ou categoria..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
        @if(request('search'))
            <div class="mt-2">
                <a href="{{ route('receipts.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Limpar busca
                </a>
                <span class="text-muted ms-2">Resultados para: "{{ request('search') }}"</span>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($receipts->count() > 0)
            <div class="row">
                @foreach($receipts as $receipt)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ Storage::url($receipt->image_path) }}" class="card-img-top" alt="{{ $receipt->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $receipt->title }}</h5>
                            <p class="card-text">
                                <strong>Valor:</strong> R$ {{ number_format($receipt->amount, 2, ',', '.') }}<br>
                                <strong>Data:</strong> {{ $receipt->date->format('d/m/Y') }}<br>
                                <strong>Tipo:</strong> 
                                @if($receipt->type == 'income')
                                    <span class="badge bg-success">Receita</span>
                                @else
                                    <span class="badge bg-danger">Despesa</span>
                                @endif
                                <br>
                                <strong>Categoria:</strong> 
                                <span class="badge" style="background-color: {{ $receipt->category->color }}; color: white;">
                                    {{ $receipt->category->name }}
                                </span>
                            </p>
                            @if($receipt->description)
                                <p class="card-text">{{ Str::limit($receipt->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('receipts.show', $receipt->id) }}" class="btn btn-sm btn-info">
                                    Mostrar <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('receipts.edit', $receipt->id) }}" class="btn btn-sm btn-primary">
                                    Editar <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('receipts.pdf', $receipt->id) }}" class="btn btn-sm btn-secondary" title="Gerar PDF" target="_blank">
                                    Gerar PDF <i class="bi bi-filetype-pdf"></i>
                                </a>
                                <form action="{{ route('receipts.destroy', $receipt->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este comprovante?')">
                                        Excluir <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Mostrando {{ $receipts->firstItem() }} a {{ $receipts->lastItem() }} de {{ $receipts->total() }} resultados
                </div>
                <div>
                    {{ $receipts->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-receipt" style="font-size: 3rem;"></i>
                <h4 class="mt-3">
                    @if(request('search'))
                        Nenhum comprovante encontrado para "{{ request('search') }}"
                    @else
                        Nenhum comprovante encontrado
                    @endif
                </h4>
                <p class="text-muted">
                    @if(request('search'))
                        Tente ajustar os termos da busca ou
                    @endif
                    Comece criando seu primeiro comprovante
                </p>
                <a href="{{ route('receipts.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Criar Comprovante
                </a>
                @if(request('search'))
                    <a href="{{ route('receipts.index') }}" class="btn btn-outline-secondary mt-2 ms-2">
                        <i class="bi bi-arrow-left"></i> Ver todos os comprovantes
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection