@extends('layouts.app')
@section('content')
    
       
<div class="container">
<h2 class="text-light text-center" style="margin-top: 2vh;">Create New Exam</h2>
    
    {{-- 提交（POST）到存储方法中，若要提交图片，要额外注明enctype --}}
   {!! Form::open(['action'=> 'ExamsController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
   {{ csrf_field() }}

    <div class="form-group">
       {{ Form::label('title', ' Title :') }}
      {{--  第一个值是key,第二个是默认值,后面还可以指定属性 --}}
       {{Form::text('title','',['class'=>'form-control','required'])}}
    </div>

     <div class="form-group">
       {{ Form::label('description', ' Descripiton(Opt) :') }}
       {{-- 这里使用了id加上api --}}
       {{ Form::textarea('description','',['id'=>'article-ckeditor','class'=>'form-control']) }}
    </div>

    <div class="form-group">
      <label for="sel2">This exam belongs to:</label>
      <select class="form-control" id="sel2" name="material_id" required>
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title'] }}</option>  
            @endforeach
      </select>
    </div>

    
    <div class="form-group">
         {{ Form::label('marks', ' Enter marks* : ') }}
         <input type="number" class="form-control" name="marks" required>
    </div>


     <div class="form-group">
        <label for="exams_file" class="text-warning"><b>Please upload the pdf file only!</b></label><br>
        {{ Form::file('exams_file',['required']) }}
    </div>
  
    {{Form::submit('Upload ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
    <a href="/exams" class="btn btn-default">Cancel</a>
    {!! Form::close() !!}   
   

    </div>
    
@endsection
