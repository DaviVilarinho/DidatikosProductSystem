@extends('base')

@section('title', 'Novo Produto')

@section('content')
    <product-form :is-edition="false"></product-form>
@endsection
