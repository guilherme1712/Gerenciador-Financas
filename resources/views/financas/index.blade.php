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
        color: black;
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
        <div class="col-6 contas-table"></div>

        <div class="col-6 creditos-table">

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
    <div class="d-flex align-items-center justify-content-center" style="height: 20vh;">
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

<div class="emailsRecebidos">
    <div class="col-6 emails-table"></div>
</div>

@include('financas.modal.conta_modal')

@endsection
