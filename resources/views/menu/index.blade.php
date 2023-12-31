<!-- resources/views/financas/index.blade.php -->

@extends('layouts.menu')

@section('content-menu')

<style>
    .btn-primary {
        background-color: #013755;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #012345;
    }

    .content {
        align-items: center;
        justify-content: center;
    }

</style>

<div class="content d-flex flex-column align-items-center">

    <div class="btn-group" style="margin-top: 20px;">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Adicionar</button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/financas/addConta') }}">Adicionar Nova Conta</a>
            <a class="dropdown-item" href="{{ url('/financas/addCredito') }}">Adicionar Novo Crédito</a>
        </div>
    </div>

    <div class="btn-group" style="margin-top: 20px;">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Histórico</button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/financas/buscaListadoContas') }}">Histórico de Contas</a>
            <a class="dropdown-item" href="{{ url('/financas/buscaListadoCreditos') }}">Histórico de Créditos</a>
        </div>
    </div>





    <!-- <div style="margin-top: 20px;">
        <a class="btn btn-primary" href="/APIs/Laravel/Gerenciador-Financas/public/financas/addCredito">Adicionar Novo Crédito</a>
    </div> -->

    <!-- <div style="margin-top: 20px;">
        <a class="btn btn-primary" href="/APIs/Laravel/Gerenciador-Financas/public/financas/buscaListadoContas">Histórico de Contas</a>
    </div>

    <div style="margin-top: 20px;">
        <a class="btn btn-primary" href="/APIs/Laravel/Gerenciador-Financas/public/financas/buscaListadoCreditos">Histórico de Créditos</a> -->
    <!-- </div> -->

    <div style="margin-top: 20px;">
        <a class="btn btn-primary" href="/APIs/Laravel/Gerenciador-Financas/public/financas/faturas">Fatura Cartão de Credito</a>
    </div>

    <div style="margin-top: 20px;">
        <a class="btn btn-primary" href="/APIs/Laravel/Gerenciador-Financas/public/financas/export-excel">Gerar Exel do Mês</a>
    </div>

    <div style="margin-top: 50px; align-self: center;">
        <a class="btn btn-primary" href="/APIs/Laravel/Gerenciador-Financas/public/financas/admin">Administrar</a>
    </div>
</div>



@endsection
