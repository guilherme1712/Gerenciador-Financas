<!-- resources/views/financas/edit-conta.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Editar Conta</h2>
        </div>

        {!! Form::open(['url' => route('financas.saveEditConta', ['id' => $conta->id]), 'method' => 'post']) !!}

            {{ Form::hidden('id', $conta->id) }}

            <div class="form-group row">
                {{ Form::label('data', 'Data:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('data', $conta->data, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('descricao', 'Descrição:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('descricao', $conta->descricao, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('valor', 'Valor:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('valor', $conta->valor, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('recorrente', 'Recorrente?', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('recorrente', ['1' => 'Sim', '0' => 'Não'], $conta->recorrente, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('data_termino_recorrente', 'Até quando é recorrente?', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('data_termino_recorrente', $conta->data_termino_recorrente, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('status', 'Status:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('status', ['1' => 'Pago', '0' => 'Não Pago'], $conta->status, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('banco', 'Banco:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('banco', $formatedBancos, $conta->banco, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('categoria', 'Categoria:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('categoria', $formatedCategorias, $conta->categoria, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group text-center">
                {{ Form::submit('Salvar Conta', ['class' => 'btn btn-primary']) }}
            </div>
        {!! Form::close() !!}

        <a class="btn btn-back" href="{{ route('financas.index') }}">Voltar</a>
    </div>
@endsection
