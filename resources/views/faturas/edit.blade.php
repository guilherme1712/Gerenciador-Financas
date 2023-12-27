<!-- resources/views/faturas/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Editar Fatura</h2>
        </div>

        {!! Form::open(['url' => route('fatura.salvar', ['id' => $fatura->id]), 'method' => 'post']) !!}
            {{ Form::hidden('id', $fatura->id) }}

            <div class="form-group row">
                {{ Form::label('mes_referencia', 'Mês de Referência:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('mes_referencia_display', date('m/Y', strtotime($fatura->mes_referencia)), ['class' => 'form-control', 'disabled']) }}
                    {{ Form::hidden('mes_referencia', $fatura->mes_referencia) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('valor', 'Valor:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('valor', $fatura->valor, ['class' => 'form-control', 'required']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('status', 'Status:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('status', ['0' => 'Não Paga', '1' => 'Paga'], $fatura->status, ['class' => 'form-control', 'required']) }}
                </div>
            </div>

            <!-- Adicione outros campos conforme necessário -->
            <div class="form-group row">
                <div class="col-1" style="text-align: start;">
                    <a class="btn btn-back" href="{{ url()->previous() }}">Voltar</a>
                </div>
                <div class="col-11 form-group text-center">
                    {{ Form::submit('Salvar Fatura', ['class' => 'btn btn-primary']) }}
                </div>
            </div>

        {!! Form::close() !!}

    </div>
@endsection
