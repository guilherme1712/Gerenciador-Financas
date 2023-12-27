<!-- resources/views/financas/edit-conta.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Editar Conta</h2>
        </div>

        {!! Form::open(['url' => route('financas.saveEditConta', ['id' => $conta->id]), 'method' => 'post', 'id' => 'editContaForm']) !!}

            {{ Form::hidden('id', $conta->id) }}

            <div class="form-group row">
                {{ Form::label('data', 'Data:', ['class' => 'col-md-2 col-form-label', 'style' => 'display:none;']) }}
                <div class="col-md-10">
                    {{ Form::date('data', date('Y-m-d', strtotime($conta->data)), ['class' => 'form-control', 'style' => 'display:none;']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('vencimento', 'Vencimento:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('vencimento', date('Y-m-d', strtotime($conta->vencimento)), ['class' => 'form-control']) }}
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
                    {{ Form::select('recorrente', ['1' => 'Sim', '0' => 'Não'], $conta->recorrente, ['class' => 'form-control', 'readonly' => true, 'disabled' => true, 'id' => 'recorrenteField']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('data_termino_recorrente', 'Até quando é recorrente?', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::date('data_termino_recorrente', date('Y-m-d', strtotime($conta->data_termino_recorrente)), ['class' => 'form-control', 'readonly' => true, 'disabled' => true, 'id' => 'dataTerminoField']) }}
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
                {{ Form::submit('Salvar Conta', ['class' => 'btn btn-primary', 'onclick' => 'removeAttributes()']) }}
            </div>

        {!! Form::close() !!}

        <a class="btn btn-back" href="{{ route('financas.index') }}">Voltar</a>
    </div>

    <script>
        function removeAttributes() {
            document.getElementById('recorrenteField').removeAttribute('readonly');
            document.getElementById('recorrenteField').removeAttribute('disabled');

            document.getElementById('dataTerminoField').removeAttribute('readonly');
            document.getElementById('dataTerminoField').removeAttribute('disabled');
        }
    </script>
@endsection
