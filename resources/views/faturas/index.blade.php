<!-- Em resources/views/faturas/index.blade.php -->
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
                <a class="btn btn-back" href="{{ route('menu') }}">Voltar</a>
            </div>
            <div class="col-md-11" style="text-align: center;">
                <h2>Faturas Cartão de Crédito</h2>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Mês Referência</th>
                    <th>Valor</th>
                    <th>Dia Fechamento</th>
                    <th>Dia Vencimento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faturas as $fatura)
                    <tr>
                        <td>{{ date('m/Y', strtotime($fatura->mes_referencia )) }}</td>
                        <td>R$ {{ number_format($fatura->valor, 2, ',', '.') }}</td>
                        <td>{{ $fatura->dia_fechamento }}</td>
                        <td>{{ $fatura->dia_vencimento }}</td>
                        <td>{{ $fatura->status == 1 ? 'Paga' : 'Não Paga' }}</td>
                        <td>
                            <a href="{{ route('fatura.editar', ['id' => $fatura->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="{{ route('fatura.confirmDelete', ['id' => $fatura->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <!-- <a class="js-conta-detalhes-credito" data-id="{{ $fatura->id }}" class="btn-outline-primary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a> -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
