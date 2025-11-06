@extends('layouts.app')

@section('title', 'Comprovantes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Comprovantes</h2>
    <a href="{{ route('receipts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Comprovante
    </a>
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
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('receipts.edit', $receipt->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('receipts.destroy', $receipt->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este comprovante?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $receipts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-receipt" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Nenhum comprovante encontrado</h4>
                <p class="text-muted">Comece criando seu primeiro comprovante</p>
                <a href="{{ route('receipts.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Criar Comprovante
                </a>
            </div>
        @endif
    </div>
</div>
@endsection