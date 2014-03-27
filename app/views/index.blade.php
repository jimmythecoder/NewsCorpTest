@extends('layout')

@section('content')


    {{ Form::open(array('action' => 'HomeController@showBestRecipe','class' => 'form-horizontal')) }}
<fieldset>

    <legend>Recipe decision maker</legend>

    <div class="control-group">
    {{ Form::label('ingredients','Ingredients', array('class' => 'control-label'))}}
        <div class="controls">
        {{ Form::textarea('ingredients')}}
        </div>
    </div>
        <div class="control-group">
    {{ Form::label('recipes','Recipes', array('class' => 'control-label'))}}
            <div class="controls">
            {{ Form::textarea('recipes')}}
            </div>
        </div>

    <div class="control-group">
        <div class="controls">
        {{ Form::submit('Find my Recipe!', array('class' => 'btn btn-primary')) }}
        </div>
    </div>

</fieldset>
    {{ Form::close() }}

<div id="examples">
    <div class="csv">
        <h3>CSV Ingredients</h3>
<span>bread,10,slices,25/12/2014<br />
cheese,10,slices,25/12/2014<br />
butter,250,grams,25/12/2014<br />
peanut butter,250,grams,2/12/2014<br />
mixed salad,150,grams,26/12/2013</span>
    </div>

    <div class="json">
<h3>JSON Recipe</h3>
        <span>
[{
    "name": "grilled cheese on toast",
    "ingredients": [
        { "item":"bread", "amount":"2", "unit":"slices"},
        { "item":"cheese", "amount":"2", "unit":"slices"}
    ]
 },
 {
    "name": "salad sandwich",
    "ingredients": [
        { "item":"bread", "amount":"2", "unit":"slices"},
        { "item":"mixed salad", "amount":"100", "unit":"grams"}
    ]
 }
]
            </span>
    </div>
</div>

@stop