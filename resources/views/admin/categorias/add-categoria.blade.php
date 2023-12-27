<!-- resources/views/categorias/add-categoria.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Adicionar Categoria</h2>
        </div>
        {!! Form::open(['url' => route('admin.categorias.save'), 'method' => 'post']) !!}

            <div class="form-group row">
                {{ Form::label('categoria_id', 'Categoria id:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::number('categoria_id', $ultimoIdCategoria + 1, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('nome', 'Nome:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('nome', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('secao', 'Seção:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('secao', ['' => 'Selecione', '1' => 'Contas', '2' => 'Créditos'], null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('ativo', 'Ativo?:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('ativo', ['0' => 'Não', '1' => 'Sim'], 1, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group text-center">
                {{ Form::submit('Adicionar Categoria', ['class' => 'btn btn-primary']) }}
            </div>
        {!! Form::close() !!}

        <a class="btn-back" href="javascript:history.back()">Voltar</a>
    </div>
@endsection
