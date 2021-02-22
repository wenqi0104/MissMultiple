@extends('layouts.app')
@section('content')





    <h2>Create New Exercise Test</h2>

    {{-- 提交（POST）到存储方法中，若要提交图片，要额外注明enctype --}}
   {!! Form::open(['action'=> 'ExercisesController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
   {{ csrf_field() }}
    <div class="form-group">
       {{ Form::label('title', ' Title :') }}
      {{--  第一个值是key,第二个是默认值,后面还可以指定属性 --}}
       {{Form::text('title','',['class'=>'form-control'])}}
    </div>
    <div class="form-group">
      <label for="sel2">This exercise belongs to:</label>
      <select multiple class="form-control" id="sel2" name="material_id" required>
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title'] }}</option>  
            @endforeach
      </select>
    </div>
   


    <div class="row input-group control-group increment">

      <div class="form-group col-4 ">
         {{ Form::label('questions', ' Question here* : ') }}
         {{ Form::text('questions[]','',['class'=>'form-control','required']) }}
      </div>
      <div class="form-group col-4">
         {{ Form::label('correct_answers', ' Enter Correct Answers* : ') }}
         {{ Form::text('correct_answers[]','',['class'=>'form-control','required']) }}
      </div>
      <div class="form-group col-4">
         {{ Form::label('marks', ' Enter marks* : ') }}
         {{ Form::text('marks[]','',['class'=>'form-control','required']) }}
      </div>

      
      <div class="form-group">
         <a href="#demo" class="btn btn-info" data-toggle="collapse">Add 3 Options</a>
         <div id="demo" class="collapse row">
            <div class="col-4">
               <label for="mcq">Option 1*</label>
               <input type="text" name="mcq[]" class="form-control">
            </div>
            <div class="col-4">
               <label for="mcq">Option 2*</label>
               <input type="text" name="mcq[]" class="form-control">
            </div>
            <div class="col-4">
               <label for="mcq">Option 3</label>
               <input type="text" name="mcq[]" class="form-control">
            </div>
         </div>
      </div>


      <div class="input-group-btn">
         <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
      </div>
      
    </div>


    
    <div class="row clone hide">
      <div class="control-group input-group" style="margin-top:10px">

      <div class="form-group col-4 ">
         {{ Form::label('questions', ' Question here* : ') }}
         {{Form::text('questions[]','',['class'=>'form-control','required'])}}
      </div>
      <div class="form-group col-4">
         {{ Form::label('correct_answers', ' Enter Correct Answers* : ') }}
         {{Form::text('correct_answers[]','',['class'=>'form-control','required'])}}
      </div>
      <div class="form-group col-4">
         {{ Form::label('marks', ' Enter marks* : ') }}
         {{Form::text('marks[]','',['class'=>'form-control','required'])}}
      </div>

      <div class="form-group">
         <a href="#demo" class="btn btn-info" data-toggle="collapse">Add 3 Options</a>
         <div id="demo" class="collapse row">
            <div class="col-4">
               <label for="mcq">Option 1*</label>
               <input type="text" name="mcq[]" class="form-control">
            </div>
            <div class="col-4">
               <label for="mcq">Option 2*</label>
               <input type="text" name="mcq[]" class="form-control">
            </div>
            <div class="col-4">
               <label for="mcq">Option 3</label>
               <input type="text" name="mcq[]" class="form-control">
            </div>
         </div>
      </div>

         <div class="input-group-btn"> 
               <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
         </div>
      </div>
    </div>


    {{Form::submit('Upload ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
    {!! Form::close() !!}   
   
    

   

@endsection



