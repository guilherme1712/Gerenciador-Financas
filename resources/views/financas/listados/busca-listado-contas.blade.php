<!-- resources/views/busca/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Buscar Contas</h2>
        </div>

        <form action="{{ route('financas.listadoContas') }}" method="post" class="mx-auto">
            @csrf
            <div class="form-group row">
                <label for="dataDesde" class="col-md-2 col-form-label">Data Desde:</label>
                <div class="col-md-10">
                    <input type="date" name="dataDesde" id="dataDesde" class="form-control" value="{{ date('Y-m-01') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="dataFim" class="col-md-2 col-form-label">Data Fim:</label>
                <div class="col-md-10">
                    <input type="date" name="dataFim" id="dataFim" class="form-control" value="{{ date('Y-m-t') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="valor" class="col-md-2 col-form-label">Valor:</label>
                <div class="col-md-10">
                    <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor">
                </div>
            </div>

            <div class="form-group row">
                <label for="recorrente" class="col-md-2 col-form-label">Recorrente:</label>
                <div class="col-md-10">
                    <select name="recorrente" id="recorrente">
                        <option value="" selected disabled>Selecione</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="banco" class="col-md-2 col-form-label">Status:</label>
                <div class="col-md-10">
                    <select class="form-control" id="status" name="status">
                        <option value="" selected disabled>Selecione</option>
                        <option value="1">Pago</option>
                        <option value="0">Não Pago</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="banco" class="col-md-2 col-form-label">Banco:</label>
                <div class="col-md-10">
                    <select name="banco" id="banco" class="form-control">
                        <option value="" selected disabled>Selecione</option>
                        @foreach($formatedBancos as $id => $nome)
                            <option value="{{ $id }}">{{ $nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="categoria" class="col-md-2 col-form-label">Categoria:</label>
                <div class="col-md-10">
                    <select name="categoria" id="categoria" class="form-control">
                        <option value="" selected disabled>Selecione</option>
                        @foreach($formatedCategorias as $id => $nome)
                            <option value="{{ $id }}">{{ $nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1" style="text-align: start;">
                    <a class="btn btn-back" href="{{ route('menu') }}">Voltar</a>
                </div>
                <div class="col-md-11" style="text-align: center;">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
