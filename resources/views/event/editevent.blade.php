@extends('layouts.app')

@section('content')
    <h1>Edit Acara</h1>
    @include('event.formevent', ['event' => $event])
@endsection
