@extends('layouts.app')

@section('content')
@livewire('document.document-form', ['document' => $document])
@endsection