@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    form {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    h2 {
        color: #1a73e8;
    }

    label {
        display: block;
        margin: 10px 0 5px;
        color: #555;
        text-align: left;
    }

    input {
        width: calc(100% - 16px);
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #dadce0;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        background-color: #1a73e8;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        background-color: #0f4fa9;
    }

    p.error-message {
        color: red;
        margin-top: 10px;
        text-align: center;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -5px;
        margin-left: -5px;
    }

    .col-md-4,
    .col-md-6,
    .offset-md-4,
    .form-check {
        padding-right: 5px;
        padding-left: 5px;
    }

    .mb-3 {
        margin-bottom: 15px;
    }

    .offset-md-4 {
        margin-left: 33.33333%;
    }

    .form-check-label {
        color: #555;
    }

    .btn-link {
        color: #1a73e8;
        text-decoration: none;
        background-color: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .btn-link:hover {
        text-decoration: underline;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <h2>Registro</h2>

                    @if(session('error'))
                        <p class="error-message">{{ session('error') }}</p>
                    @endif

                    <div class="col-md-12">
                        <!-- Nome -->
                        <label for="name" class="col-md-12 col-form-label">{{ __('Nome') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Adicione o campo de upload da imagem -->
                    <div class="row mb-3">
                        <label for="image" class="col-md-12 col-form-label">{{ __('Imagem de Perfil') }}</label>
                        <div class="col-md-12">
                            <input id="image" type="file" class="form-control" name="image" accept="image/*">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row mb-3">
                        <label for="email" class="col-md-12 col-form-label">{{ __('Endereço de Email') }}</label>
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Senha -->
                    <div class="row mb-3">
                        <label for="password" class="col-md-12 col-form-label">{{ __('Senha') }}</label>
                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirmação de Senha -->
                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-12 col-form-label">{{ __('Confirme a Senha') }}</label>
                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Botão de Registro -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
