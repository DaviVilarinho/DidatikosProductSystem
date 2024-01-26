@extends('base')

@section('title', 'Editar Produto')

@section('content')
    <product-form :is-edition="true" :id-search="{{ request()->route('id') }}"></product-form>
@endsection
