<!-- resources/views/categorias/index.blade.php -->

@extends('layouts.app')

@section('content')
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        p {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        h1 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center; /* Centraliza horizontalmente */
            vertical-align: middle; /* Centraliza verticalmente */
        }

        .table th {
            background-color: #f2f2f2;
        }

        .col-content {
            margin-left: 1%;
            margin-top: 20px;
        }

        .row {
            margin-right: 0px !important;
        }
    </style>

    <div class="container">

        <div class="form-group row">
            <div class="col-md-1" style="text-align: start;">
                <a class="btn-back" href="javascript:history.back()">Voltar</a>
            </div>
            <div class="col-md-11" style="text-align: center;">
                <h2>Categorias</h2>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Seção</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)

                    <tr>
                        <td>{{ $categoria->nome }}</td>
                        <td>{{ ($categoria->secao == 1) ? 'Contas' : 'Créditos' }}</td>
                        <td>{{ ($categoria->ativo == 1) ? 'Sim' : 'Não' }}</td>
                        <td>
                            <a href="{{ route('admin.categorias.edit', ['id' => $categoria->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="{{ route('admin.categorias.confirmDelete', ['id' => $categoria->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
