@extends('layouts.app')

@section('content')
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
            }

            .container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .confirmation-message {
                margin-bottom: 20px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
            }

            .btn-primary {
                background-color: #dc3545;
                color: #fff;
                margin-right: 10px;
            }

            .btn-primary:hover {
                background-color: #c82333;
            }

            .btn-secondary {
                background-color: #007bff;
                color: #fff;
            }

            .btn-secondary:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <div class="container">
        <h2>Deletar Conta</h2>

        <p class="confirmation-message">Você tem certeza que deseja deletar esta conta?</p>

        <div class="form-group">
            <label for="nomeConta">Conta:</label>
            <input type="text" id="nomeConta" name="nomeConta" value="{{ $conta->descricao }}" class="form-control" readonly>
        </div>

        <form method="post" action="{{ route('financas.confirmDeleteConta', ['id' => $conta->id]) }}">
            @csrf

            <button type="submit" class="btn btn-primary" name="del" value="1">Sim</button>
            <a href="{{ route('financas.index') }}" class="btn btn-secondary">Não</a>
        </form>

    </div>
@endsection
