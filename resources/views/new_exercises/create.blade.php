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

<div class="container">
<h2 class="text-light text-center" style="margin-top: 2vh;">Create New Question</h2>
    
    {{-- 提交（POST）到存储方法中，若要提交图片，要额外注明enctype --}}
   {!! Form::open(['action'=> 'NewExercisesController@store','method'=>'POST']) !!}
   {{ csrf_field() }}
    <div class="form-group">
       {{ Form::label('title', ' Title* :') }}
        {{--  第一个值是key,第二个是默认值,后面还可以指定属性 --}}
       {{Form::text('title','',['class'=>'form-control','required'])}}
    </div>
    {{-- <div class="form-group">
      <label for="sel2">This exercise belongs to:</label>
      <select multiple class="form-control" id="sel2" name="material_id" required>
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title'] }}</option>  
            @endforeach
      </select>
    </div> --}}
    <div class="row from-group">
        <div class="col-4 from-group">
            {{ Form::label('multiplier', ' Enter Multiplier* : ') }}
            <input type="number" name="multiplier" class="form-control" required>
        </div>
        <div class="col-4 from-group">
            {{ Form::label('multiplicand', ' Enter Multiplicand* : ') }}
            <input type="number" name="multiplicand" class="form-control" required>
        </div>
        <div class="col-4 from-group">
            {{ Form::label('product', ' Enter Correct Answer* : ') }}
            <input type="number" name="product" class="form-control" required>
        </div>
    </div>

    <br>
    <div class="from-group optionme">
        <label for="hide">Select the part you want to hide: </label><br>
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
        <input type="number" name="marks" class="form-control" required>
    </div>

    <div class="form-group">
        <a href="#demo" class="btn btn-info text-light" data-toggle="collapse">Add 3 Options(Opt) <span class="text-warning">---Please enter 3 options at one time</span></a>
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

    {{Form::submit('Upload ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
    <a href="/new_exercises" class="btn btn-default">Cancel</a>
    {!! Form::close() !!}   
   
    </div>
@endsection