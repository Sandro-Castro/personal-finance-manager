@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nova Categoria
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('categories.search') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Buscar categorias..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Ícone</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <span class="badge" style="background-color: {{ $category->color }}; color: white;">
                                    {{ $category->name }}
                                </span>
                            </td>
                            <td>
                                @if($category->type == 'income')
                                    <span class="badge bg-success">Receita</span>
                                @else
                                    <span class="badge bg-danger">Despesa</span>
                                @endif
                            </td>
                            <td>{{ $category->icon }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
             <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Mostrando {{ $categories->firstItem() }} a {{ $categories->lastItem() }} de {{ $categories->total() }} resultados
                    </div>
                    <div>
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            
        @else
            <div class="text-center py-5">
                <i class="bi bi-folder-x" style="font-size: 3rem;"></i>
                <h4 class="mt-3">Nenhuma categoria encontrada</h4>
                <p class="text-muted">Comece criando sua primeira categoria</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Criar Categoria
                </a>
            </div>
        @endif
    </div>
</div>
@endsection