<!-- resources/views/financas/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Finanças</h2>

        <!-- Botões para administrar categorias -->
        <div class="mb-4">
            <div class="btn-group mr-2" role="group" aria-label="Administrar Categorias">
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-primary">Ver Categorias</a>
                <a href="{{ route('admin.categorias.add') }}" class="btn btn-primary">Criar Categorias</a>
            </div>
        </div>

        <!-- Botões para administrar bancos e faturas de cartão de crédito -->
        <div class="mb-4">
            <div class="btn-group mr-2" role="group" aria-label="Administrar Bancos e Faturas">
                <a href="#" class="btn btn-primary">Administrar Bancos</a>
                <a href="{{ route('fatura.criar-manualmente') }}" class="btn btn-primary">Criar Manualmente Faturas de Cartão de Crédito</a>
            </div>
        </div>

        <!-- Botão para voltar para o menu -->
        <div class="mb-4">
            <a href="{{ route('menu') }}" class="btn btn-secondary">Voltar para o Menu</a>
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
