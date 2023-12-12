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

    <div class="col-content">
        <div class="row">
            <a class="col-2 btn btn-back" href="{{ route('menu') }}">Voltar</a>
            <h1 class="col-9 js-name-page">Lista de Créditos</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table" id="tabelaListadoCredito">
                    <thead style="position: sticky; top: 0; opacity: 1; z-index: 3;">
                        <tr>
                            <th>Data</th>
                            <th>Conta</th>
                            <th>Valor</th>
                            <th>Recorrente</th>
                            <th>Termino Recorrente</th>
                            <th>Banco</th>
                            <th>Categoria</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listadoCreditos as $listadoCredito)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($listadoCredito->data)) }}</td>
                                <td>{{ $listadoCredito->descricao }}</td>
                                <td>{{ $listadoCredito->valor }}</td>
                                <td>{{ $listadoCredito->recorrente ? 'Sim' : 'Não' }}</td>
                                <td>{{ date('d/m/Y', strtotime($listadoCredito->data_termino_recorrente)) }}</td>
                                <td>{{ $listadoCredito->nome }}</td>
                                <td>{{ $listadoCredito->nomeCategoria }}</td>
                                <td>{{ ($listadoCredito->status == 1) ? 'Pago' : 'Não Pago' }}</td>

                                <input type="hidden" class="listadoCreditoId" id="listadoCreditoId" value="{{ $listadoCredito->id }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p>Total de Créditos do Mês: R$ {{ $totalCreditos }}</p>
            </div>
        </div>
    </div>
@endsection
