<!-- resources/views/categorias/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h2>Editar Categoria</h2>
        </div>
        {!! Form::model($categoria, ['url' => route('admin.categorias.update', ['id' => $categoria->id]), 'method' => 'put']) !!}

            <div class="form-group row">
                {{ Form::label('categoria_id', 'Categoria id:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::number('categoria_id', $categoria->categoria_id, ['class' => 'form-control', 'readonly']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('nome', 'Nome:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::text('nome', $categoria->nome, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('secao', 'Seção:', ['class' => 'col-md-2 col-form-label']) }}
                <div class="col-md-10">
                    {{ Form::select('secao', ['' => 'Selecione', '1' => 'Contas', '2' => 'Créditos'], $categoria->secao, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group text-center">
                {{ Form::submit('Atualizar Categoria', ['class' => 'btn btn-primary']) }}
            </div>
        {!! Form::close() !!}

        <a class="btn-back" href="javascript:history.back()">Voltar</a>
    </div>
@endsection
