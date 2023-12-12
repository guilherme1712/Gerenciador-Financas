<!-- resources/views/financas/edit-conta.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Editar Crédito</h2>
        </div>

        {!! Form::open(['url' => route('financas.saveEditCredito', ['id' => $credito->id]), 'method' => 'post']) !!}

            {{ Form::hidden('id', $credito->id) }}

            <div class="form-group row">
                {{ Form::label('data', 'Data:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('data', $credito->data, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('descricao', 'Descrição:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('descricao', $credito->descricao, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('valor', 'Valor:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('valor', $credito->valor, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('recorrente', 'Recorrente?', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('recorrente', ['1' => 'Sim', '0' => 'Não'], $credito->recorrente, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('data_termino_recorrente', 'Até quando é recorrente?', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('data_termino_recorrente', $credito->data_termino_recorrente, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('status', 'Status:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('status', ['1' => 'Creditado', '0' => 'Não Creditado'], $credito->status, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('banco', 'Banco:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('banco', $formatedBancos, $credito->banco, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('categoria', 'Categoria:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('categoria', $formatedCategorias, $credito->categoria, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group text-center">
                {{ Form::submit('Salvar Crédito', ['class' => 'btn btn-primary']) }}
            </div>
        {!! Form::close() !!}

        <a class="btn btn-back" href="{{ route('financas.index') }}">Voltar</a>
    </div>
@endsection
