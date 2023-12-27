<!-- Em resources/views/faturas/criarManualmente.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">Criar Nova Fatura Manualmente</h2>

        <form method="post" action="{{ route('fatura.salvar-manualmente') }}">
            @csrf

            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="text" id="valor" name="valor" class="form-control" value="0" required>
            </div>

            <div class="form-group">
                <label for="diaVencimento">Dia de Vencimento:</label>
                <input type="number" id="diaVencimento" name="diaVencimento" class="form-control" required min="1" max="31">
            </div>

            <div class="form-group">
                <label for="mesReferencia">Mês de Referência (mm/aaaa):</label>
                <input type="month" id="mesReferencia" name="mesReferencia" class="form-control" required value="{{ now()->format('Y-m') }}">
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="0" selected>Não Paga</option>
                    <option value="1">Paga</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary text-center">Criar Fatura</button>
        </form>
    </div>
@endsection
