<!-- resources/views/financas/add-conta.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Adicionar Conta</h2>
        </div>
        {!! Form::open(['url' => url('financas/saveConta'), 'method' => 'post']) !!}

            {{ Form::hidden('id', null) }}

            <div class="form-group row">
                {{ Form::label('data', 'Data:', ['class' => 'col-md-2 col-form-label', 'style' => 'display:none;']) }}
                <div class="col-md-10">
                    {{ Form::date('data', date('Y-m-d'), ['class' => 'form-control', 'style' => 'display:none;']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('vencimento', 'Vencimento:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('vencimento', date('Y-m-d'), ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('descricao', 'Descrição:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('descricao', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('valor', 'Valor:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('valor', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('recorrente', 'Recorrente?', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('recorrente', ['0' => 'Selecione', '1' => 'Sim', '2' => 'Não'], '', ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row" id="data_termino_recorrente_container" style="display: none;">
                {{ Form::label('data_termino_recorrente', 'Até quando é recorrente?', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('data_termino_recorrente', date('Y-m-d'), ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('status', 'Status:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('status', ['1' => 'Pago', '0' => 'Não Pago'], '1', ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('banco', 'Banco:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('banco', $formatedBancos, '1', ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('categoria', 'Categoria:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('categoria', $formatedCategorias, null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group text-center">
                {{ Form::submit('Adicionar Conta', ['class' => 'btn btn-primary']) }}
            </div>
        {!! Form::close() !!}

        <a class="btn-back" href="{{ route('home') }}">Voltar</a>
    </div>
@endsection
