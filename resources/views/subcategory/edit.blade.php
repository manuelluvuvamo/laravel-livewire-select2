@extends('layouts.app')

@section('content')
@livewire('sub-category.sub-category-form', ['subcategory' => $subcategory])
@endsection