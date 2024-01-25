@extends('base')

@section('title', 'Editar Produto')

@section('content')
    <product-form :isEdition="true" :idSearch="{{ request()->route('id') }}"></product-form>
@endsection
