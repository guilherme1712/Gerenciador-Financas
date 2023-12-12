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
        <h1 class="col-12 js-name-page text-center">Contas Mensais</h1>
    </div>

    <div class="container">
        <table class="table" id="tabelaContas">
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
                @foreach ($contasData as $conta)
                    <tr>
                        <td>{{ $conta->descricao }}</td>
                        <td>{{ date('d/m/Y', strtotime($conta->data)) }}</td>
                        <td>{{ 'R$ '. $conta->valor }}</td>
                        <td>{{ $conta->recorrente ? 'Sim' : 'Não' }}</td>
                        <td>{{ date('d/m/Y', strtotime($conta->data_termino_recorrente)) }}</td>
                        <td>{{ $conta->nomeBanco }}</td>
                        <td>{{ $conta->nomeCategoria }}</td>
                        <td>{{ $conta->status == 1 ? 'Pago' : 'Não Pago' }}</td>
                        <td>
                            <a href="{{ route('financas.editConta', ['id' => $conta->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="{{ route('financas.deleteConta', ['id' => $conta->id]) }}" class="btn-outline-primary">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>

                        <input type="hidden" class="contaId" id="contaId" value="{{ $conta->id }}">
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <a class="btn-back" href="{{ route('financas.index') }}">Voltar</a>
            <!-- <a class="btn-back" href="javascript:history.back()">Voltar</a> -->
            <hr>
            <a class="btn-back" href="{{ route('financas.creditoInfo') }}">Ver Créditos</a>
        </div>
    </div>
@endsection
