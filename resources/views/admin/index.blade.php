<!-- resources/views/financas/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Finanças</h2>

        <!-- Menu Administrar -->
        <div class="mb-4">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorias</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('admin.categorias.index') }}">Ver Categorias</a>
                    <a class="dropdown-item" href="{{ route('admin.categorias.add') }}">Criar Categorias</a>
                </div>
            </div>
        </div>

        <!-- Menu Bancos e Faturas -->
        <div class="mb-4">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bancos e Faturas</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Administrar Bancos</a>
                    <a class="dropdown-item" href="{{ route('fatura.criar-manualmente') }}">Criar Manualmente Faturas de Cartão de Crédito</a>
                </div>
            </div>
        </div>

        <!-- Botão para voltar para o menu -->
        <div class="mb-4">
            <a href="{{ route('menu') }}" class="btn btn-secondary">Voltar para o Menu</a>
        </div>

        <div class="mb-4">
            <a href="{{ route('enviarEmailContas') }}" class="btn btn-secondary">Enviar email para gdaudt17@gmail.com</a>
        </div>

        <div class="mb-4">
            <a href="{{ route('verificarRegistrosEmailContas') }}" class="btn btn-secondary">Teste enviar email contas detalhes</a>
        </div>

        <div class="mb-4">
            <a href="{{ route('testarInformeDiario') }}" class="btn btn-secondary">Teste enviar email informe fiario</a>
        </div>

        <div class="mb-4">
            <a href="{{ route('testarCriarFatura') }}" class="btn btn-secondary">Teste criar faturas</a>
        </div>

        <div class="mb-4">
            <a href="{{ route('exportToExcel') }}" class="btn btn-secondary">Gerar exel contas do mês</a>
        </div>

        <div style="margin-top: 50px; align-self: center;">
            <a class="btn btn-primary" href="/APIs/Laravel/Gerenciador-Financas/public/register-form">Registrar Usuário</a>
        </div>

        <!-- Conteúdo principal da página -->
        <div class="card">
            <div class="card-body">
                <p class="lead">Bem-vindo ao seu gerenciador financeiro!</p>
                <p>Aqui você pode controlar suas finanças, categorias, bancos e faturas de cartão de crédito.</p>
                <p>Explore as opções acima para começar.</p>
            </div>
        </div>
    </div>
@endsection
