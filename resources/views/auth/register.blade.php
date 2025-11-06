@extends('layouts.app')

@section('title', 'Registrar')

@section('content')
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="text-primary">
                        <i class="bi bi-wallet2"></i> FinanceManager
                    </h2>
                    <p class="text-muted">Crie sua conta</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            @if(old('profile_photo'))
                                <img src="{{ old('profile_photo') }}" alt="Preview" class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;" id="profilePhotoPreview">
                            @else
                                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2" style="width: 100px; height: 100px;">
                                    <i class="bi bi-person text-light" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                        </div>
                        <label for="profile_photo" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-camera"></i> Adicionar Foto
                        </label>
                        <input type="file" name="profile_photo" id="profile_photo" class="d-none" accept="image/*">
                        @error('profile_photo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">Já tem uma conta? Faça login</a>
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
                const preview = document.getElementById('profilePhotoPreview');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    // Se não existir, cria a imagem
                    const div = document.querySelector('.rounded-circle.bg-secondary');
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.alt = 'Preview';
                    newImg.className = 'rounded-circle mb-2';
                    newImg.style.width = '100px';
                    newImg.style.height = '100px';
                    newImg.style.objectFit = 'cover';
                    newImg.id = 'profilePhotoPreview';
                    div.parentNode.replaceChild(newImg, div);
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection