@extends('layouts.app')
@section('content')

<div class="container">
<h2 class="text-light text-center" style="margin-top: 2vh;">Create New Exercise Book</h2>
    
    {{-- 提交（POST）到存储方法中，若要提交图片，要额外注明enctype --}}
   {!! Form::open(['action'=> 'PapersController@store','method'=>'POST']) !!}
   {{ csrf_field() }}
    <div class="form-group">
       {{ Form::label('title', ' Title :') }}
      {{--  第一个值是key,第二个是默认值,后面还可以指定属性 --}}
       {{Form::text('title','',['class'=>'form-control','required'])}}
    </div>
    <div class="form-group">
      <label for="sel2">This exercise book belongs to:</label>
      <select  class="form-control" id="sel2" name="material_id" required>
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title'] }}</option>  
            @endforeach
      </select>
    </div>



    <div class="form-group">
      <label for="sel2">Choose the questions:(Hold shift to choose multiple questions)</label>
      <select multiple class="form-control" id="sel2" name="new_exercise_id[]" style="height: 20vh;" required>
            @foreach ($new_exercises as $new_exercise)
             <option value="{!! $new_exercise['id'] !!}" name="material_id[]" >{{ $new_exercise['title'] }}</option>  
            @endforeach
      </select>
    </div>
    
  
    {{Form::submit('Upload ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
    <a href="/papers" class="btn btn-default">Cancel</a>
    {!! Form::close() !!}   
   
    </div>
@endsection