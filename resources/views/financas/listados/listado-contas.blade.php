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
            <h1 class="col-9 js-name-page">Lista de Contas</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table" id="tabelaListadoConta">
                    <thead class="text-center" style="position: sticky; top: 0; opacity: 1; z-index: 3;">
                        <tr>
                            <th></th>
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
                        @foreach ($listadoContas as $i => $listadoConta)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ date('d/m/Y', strtotime($listadoConta->data)) }}</td>
                                <td>{{ $listadoConta->descricao }}</td>
                                <td>R$ {{ number_format($listadoConta->valor, 2, ',', '.') }}</td>
                                <td>{{ $listadoConta->recorrente ? 'Sim' : 'Não' }}</td>
                                <td>{{ date('d/m/Y', strtotime($listadoConta->data_termino_recorrente)) }}</td>
                                <td>{{ $listadoConta->nome }}</td>
                                <td>{{ $listadoConta->nomeCategoria }}</td>
                                <td>{{ ($listadoConta->status == 1) ? 'Pago' : 'Não Pago' }}</td>

                                <input type="hidden" class="listadoContaId" id="listadoContaId" value="{{ $listadoConta->id }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p>Total de Contas do Mês: R$ {{ $totalContas }}</p>
            </div>
        </div>
    </div>
@endsection
