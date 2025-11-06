@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Editar Perfil</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="Foto de perfil" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                <i class="bi bi-person text-light" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div>
                            <label for="profile_photo" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-camera"></i> Alterar Foto
                            </label>
                            <input type="file" name="profile_photo" id="profile_photo" class="d-none" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('home') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('profile_photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Substitui a imagem de perfil pela nova
                const img = document.querySelector('.rounded-circle');
                if (img.tagName === 'IMG') {
                    img.src = e.target.result;
                } else {
                    // Se for a div padrão, substitui por uma imagem
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'rounded-circle mb-3';
                    newImg.style.width = '150px';
                    newImg.style.height = '150px';
                    newImg.style.objectFit = 'cover';
                    img.parentNode.replaceChild(newImg, img);
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection