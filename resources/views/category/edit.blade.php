@extends('layouts.app')

@section('content')
@livewire('category.category-form', ['category' => $category])
@endsection