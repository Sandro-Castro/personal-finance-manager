@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Detalhes da Categoria</h4>
                <div class="btn-group">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h3>
                            <span class="badge" style="background-color: {{ $category->color }}; color: white; font-size: 1.2rem;">
                                {{ $category->icon }} {{ $category->name }}
                            </span>
                        </h3>
                        <p class="text-muted">{{ $category->description }}</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p>
                            <strong>Tipo:</strong>
                            @if($category->type == 'income')
                                <span class="badge bg-success">Receita</span>
                            @else
                                <span class="badge bg-danger">Despesa</span>
                            @endif
                        </p>
                        <p>
                            <strong>Criada em:</strong><br>
                            {{ $category->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                
                <hr>
                
                <h5>Estatísticas</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6>Total de Transações</h6>
                                <h3>-----------------</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6>Valor Total</h6>
                                <h3>----------------</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6>Última Transação</h6>
                                <h3>---------------</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection