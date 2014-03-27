@extends('layout')

@section('content')



    <p>
    @if ($recipe)
        <h1>The recipe you should cook tonight is: {{ $recipe->name }}</h1>
    @else
        <h1>Order Takeout!</h1>
    @endif
    </p>

    <p>{{ link_to('/', 'Home') }}</p>

@stop