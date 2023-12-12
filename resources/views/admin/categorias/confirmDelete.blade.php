<!-- resources/views/admin/categorias/confirmDelete.blade.php -->

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
        <h2>Deletar Categoria</h2>

        <p class="confirmation-message">Você tem certeza que deseja deletar esta categoria?</p>

        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="{{ $categoria->nome }}" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="secao">Seção:</label>
            <input type="text" id="secao" name="secao" value="{{ $categoria->secao }}" class="form-control" readonly>
        </div>

        <form method="post" action="{{ route('admin.categorias.destroy', ['id' => $categoria->id]) }}">
            @csrf
            @method('delete')

            <button type="submit" class="btn btn-danger" name="del" value="1">Sim</button>
            <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Não</a>
        </form>
    </div>
@endsection
