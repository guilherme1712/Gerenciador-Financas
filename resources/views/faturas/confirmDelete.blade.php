<!-- resources/views/faturas/confirmDelete.blade.php -->

@extends('layouts.app')
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

        .container, .container-sm, .container-md, .container-lg, .container-xl {
            max-width: 600 !important;
        }
    </style>
</head>

@section('content')
    <div class="container text-center">
        <h2>Deletar Fatura</h2>

        <p class="confirmation-message">Você tem certeza que deseja deletar esta fatura?</p>

        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" id="valor" name="valor" value="{{ $fatura->valor }}" class="form-control" readonly>
        </div>

        <form method="post" action="{{ route('fatura.deletar', ['id' => $fatura->id]) }}">
            @csrf

            <button type="submit" class="btn btn-danger" name="del" value="1">Sim</button>
            <a href="{{ route('faturas.index') }}" class="btn btn-secondary">Não</a>
        </form>
    </div>
@endsection
