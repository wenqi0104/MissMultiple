<style>
    label{
        color: #9B59B6  !important;
        font-weight: 350;
        font-size: 18px; 
    }

    .optionme span{
        font-size: 20px;
        font-weight: 350;
        color: #E67E22 ;
        margin-right: 3vw;
    }
</style>


@extends('layouts.app')
@section('content')

@php
    $c_mcq = $exercise->mcq;
    $c = explode('","',trim($c_mcq ));

    //记录有多少条数组值
    $cCount = count($c);
@endphp


<div class="container">
    <h1 class="text-light text-center" style="margin-top: 2vh;">Edit & Update Question : <span class="text-warning"> {{ $exercise->title }} </span></h1>
        {!! Form::open(['action'=> ['NewExercisesController@update',$exercise->id],'method'=>'POST']) !!}
        {{ csrf_field() }}
   <div class="form-group">
      {{ Form::label('title', ' Title* :') }}
      {{ Form::text('title',$exercise->title,['class'=>'form-control']) }}
   </div>


   <div class="row">
        <div class="col-4 from-group">
            {{ Form::label('multiplier', ' Enter Multiplier* : ') }}
            {{ Form::number('multiplier',$exercise->multiplier,['class'=>'form-control','required']) }}
        </div>
        <div class="col-4 from-group">
            {{ Form::label('multiplicand', ' Enter Multiplicand* : ') }}
            {{ Form::number('multiplicand',$exercise->multiplicand,['class'=>'form-control','required']) }}
        </div>
        <div class="col-4 from-group">
            {{ Form::label('product', ' Enter Correct Answer* : ') }}
            {{ Form::number('product',$exercise->product,['class'=>'form-control','required']) }}
        </div>
    </div>

    <br>
    <div class="from-group optionme">
        <label for="hide">Select the part you want to hide : </label><br>
        <div class="form-check form-check-inline ">
            <input class="form-check-input" type="radio" name="hide" id="inlineRadio3" value="3"><span>Hide Multiplier</span>
        </div>
        <div class="form-check form-check-inline ">
            <input class="form-check-input" type="radio" name="hide" id="inlineRadio2" value="2"><span>Hide Multiplicand</span>
        </div>
        <div class="form-check form-check-inline ">
            <input class="form-check-input" type="radio" name="hide" id="inlineRadio1" value="1" checked="true"><span>Hide Correct Answer</span>
            {{-- <label class="form-check-label" for="inlineRadio1">Hide Correct Answer</label> --}}
        </div>
    </div>

    <br>
    <div class="form-group">
        {{ Form::label('marks', ' Enter marks* : ') }}
        <input type="number" name="marks" class="form-control" value="{{ $exercise->marks }}" required>
    </div>

    
        @if ($cCount > 2)
         {{ Form::label('options', ' Enter options : ') }} 
         <div class="form-group row">
             @foreach ($c as $item)       
            <div class="col-4">
            {{ Form::number('mcq[]',$item,['class'=>'form-control']) }}
            </div>   
             @endforeach
             </div>
         @else
            <div class="form-group">
                <a href="#demo" class="btn btn-info text-light " data-toggle="collapse">Add 3 Options(Opt) <span class="text-warning">---Please enter 3 options at one time</span></a>
                <div id="demo" class="collapse row">
                    <div class="col-4">
                        <label for="mcq">Option 1</label>
                        <input type="number" name="mcq[]" class="form-control">
                    </div>
                    <div class="col-4">
                        <label for="mcq">Option 2</label>
                        <input type="number" name="mcq[]" class="form-control">
                    </div>
                    <div class="col-4">
                        <label for="mcq">Option 3</label>
                        <input type="number" name="mcq[]" class="form-control">
                    </div>
                </div>
            </div>
         @endif

        {{ Form::hidden('_method','PUT') }}
        {{ Form::submit('Update ',['class'=>'btn btn-primary','id'=>'uploadme']) }}
        <a href="/new_exercises">Cancel</a>
        {!! Form::close() !!}   
      
{{--         <div style="position: relative">
            @if (!Auth::guest())
                @if(Auth::user()->type !== "Student" )
                    {!! Form::open(['action'=> ['NewExercisesController@destroy',$exercise->id],'method'=>'POST', 'class'=>'pull-right']) !!}
                    {{ Form::hidden('_method','DELETE') }}
                    {{ Form::submit('Delete',['class'=>'btn btn-danger','style'=>'position:absolute;top:-6vh; right:20vw;']) }}
                    {!! Form::close() !!}  
                @endif
            @endif
        </div> --}}

</div>



@endsection