<!-- resources/views/financas/index.blade.php -->

@extends('layouts.app')

@section('content')

    <style>
        p {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        a {
            text-decoration: none;
            color:black;
            margin-right: 10px;
            cursor: pointer;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        h2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center !important; /* Centraliza horizontalmente */
            vertical-align: middle !important; /* Centraliza verticalmente */
        }

        .table th {
            background-color: #f2f2f2;
        }

        .col-content {
            margin-left: 1%;
            margin-top: 10px;
        }

        .index-h1 {
            font-size: 30px;
        }

        .totais {
            justify-content: center;
        }

        .js-conta-detalhes {
            color: #007bff;
            cursor: pointer;
        }
    </style>

    <div class="col-content">
        <div class="row index-h1">
            <!-- <h2 class="col-6">Lista de Contas</h2>
            <h2 class="col-6">Lista de Créditos</h2> -->

            <h2 class="col-6">Últimas Contas</h2>
            <h2 class="col-6">Últimos Créditos</h2>
        </div>

        <div class="row">
            <div class="col-6">
                <table class="table">
                    <thead style="position: sticky; top: 0; opacity: 1; z-index: 3;" class="thead-primary">
                        <tr class="text-primary bg-primary">
                            <th>Data</th>
                            <th>Conta</th>
                            <th>Valor</th>
                            <th>Recorrente</th>
                            <th>Termino Recorrente</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contas as $conta)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($conta->data )) }}</td>
                                <td>
                                    <a>{{ $conta->descricao }}</a >
                                </td>
                                <td class="col-md-auto">R$ {{ $conta->valor }}</td>
                                <td>{{ $conta->recorrente ? 'Sim' : 'Não' }}</td>
                                <td>{{ date('d/m/Y', strtotime($conta->data_termino_recorrente )) }}</td>
                                <td>{{ $conta->status == 1 ? 'Pago' : 'Não Pago' }}</td>
                                <td>
                                    <a href="{{ route('financas.editConta', ['id' => $conta->id]) }}" class="btn-outline-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('financas.deleteConta', ['id' => $conta->id]) }}" class="btn-outline-primary">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <a class="js-conta-detalhes-conta" data-id="{{ $conta->id }}" class="btn-outline-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                </td>

                                <input type="hidden" class="contaId" id="contaId" value="{{ $conta->id }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-6" style="">
                <table class="table">
                    <thead style="position: sticky; top: 0; opacity: 1; z-index: 3;">
                        <tr class="text-primary">
                            <th>Data</th>
                            <th>Crédito</th>
                            <th>Valor</th>
                            <th>Recorrente</th>
                            <th>Termino Recorrente</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($creditos as $credito)
                        <tr>
                                <td>{{ date('d/m/Y', strtotime($credito->data )) }}</td>
                                <td>{{ $credito->descricao }}</td>
                                <td>R$ {{ $credito->valor }}</td>
                                <td>{{ $credito->recorrente ? 'Sim' : 'Não' }}</td>
                                <td>{{ date('d/m/Y', strtotime($credito->data_termino_recorrente )) }}</td>
                                <td>{{ $credito->status == 1 ? 'Creditado' : 'Não Creditado' }}</td>
                                <td>
                                    <a href="{{ route('financas.editCredito', ['id' => $credito->id]) }}" class="btn-outline-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('financas.deleteCredito', ['id' => $credito->id]) }}" class="btn-outline-primary">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <a class="js-conta-detalhes-credito" data-id="{{ $credito->id }}" class="btn-outline-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                </td>
                                <input type="hidden" class="creditoId" id="creditoId" value="{{ $credito->id }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row totais">
            <div class="col-3">
                <p>Total de Contas: R$ {{ $totalContas }}</p>
            </div>
            <div class="col-4">
                <p>Total do Mês: R$ {{ $totalMes }}</p>
            </div>
            <div class="col-3">
                <p>Total de Créditos: R$ {{ $totalCreditos }}</p>
            </div>
        </div>
    </div>

    <div class="text-center mt-6">
        <div class="d-flex align-items-center justify-content-center" style="height: 30vh;">
            <a class="col-5 btn btn-info text-white position-relative" href="{{ route('financas.contaInfo') }}">
                Contas
                <span class="badge bg-secondary position-absolute bottom-0 start-50 translate-middle-x js-count-contas"></span>
            </a>

            <a class="col-5 btn btn-info text-white position-relative" href="{{ route('financas.creditoInfo') }}">
                Créditos
                <span class="badge bg-secondary position-absolute bottom-0 start-50 translate-middle-x js-count-creditos"></span>
            </a>
        </div>
    </div>

    @include('financas.modal.conta_modal')

@endsection
