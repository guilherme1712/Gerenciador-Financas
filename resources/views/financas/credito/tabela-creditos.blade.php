<!-- resources/views/financas/add-conta.blade.php -->

@extends('layouts.app')

@section('content')
    <style>
        .table th,
        .table td {
            padding: 8px;
            text-align: center !important; /* Centraliza horizontalmente */
            vertical-align: middle !important; /* Centraliza verticalmente */
        }
    </style>

    <div class="row">
        <h1 class="col-12 js-name-page text-center">Créditos Mensais</h1>
    </div>

    <div class="container">
        <table class="table" id="tabelaCreditos">
            <thead style="position: sticky; top: 0; opacity: 1; z-index: 3;">
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th class="col-2">Valor</th>
                    <th>Recorrente</th>
                    <th>Término Recorrente</th>
                    <th>Banco</th>
                    <th>Categoria</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($creditosData as $credito)
                    <tr>
                        <td>{{ $credito->descricao }}</td>
                        <td>{{ date('d/m/Y', strtotime($credito->data)) }}</td>
                        <td>R$ {{ number_format($credito->valor, 2, ',', '.') }}</td>
                        <td>{{ $credito->recorrente ? 'Sim' : 'Não' }}</td>
                        <td>{{ date('d/m/Y', strtotime($credito->data_termino_recorrente)) }}</td>
                        <td>{{ $credito->nomeBanco }}</td>
                        <td>{{ $credito->nomeCategoria }}</td>
                        <td>{{ $credito->status == 1 ? 'Pago' : 'Não Pago' }}</td>
                        <td>
                            <a href="{{ route('financas.editCredito', ['id' => $credito->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="{{ route('financas.deleteCredito', ['id' => $credito->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>

                        <input type="hidden" class="contaId" id="contaId" value="{{ $credito->id }}">
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <a class="btn-back" href="{{ route('financas.index') }}">Voltar</a>
            <hr>
            <a class="btn-back" href="{{ route('financas.contaInfo') }}">Ver Contas</a>
        </div>
    </div>
@endsection
