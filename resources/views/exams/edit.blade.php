@extends('layouts.app')
@section('content')
    

 <div class="container">
<h1 class="text-light text-center" style="margin-top: 2vh;">Edit & Update Quiz : <span class="text-warning"> {{ $exam->title }} </span></h1>

{{-- 提交（POST）到存储方法中，若要提交图片，要额外注明enctype --}}
   {!! Form::open(['action'=> ['ExamsController@update',$exam->id],'method'=>'POST','enctype'=>'multipart/form-data','files'=>true]) !!}
   {{ csrf_field() }}

    <div class="form-group">
       {{ Form::label('title', ' Title :') }}
      {{--  第一个值是key,第二个是默认值,后面还可以指定属性 --}}
       {{Form::text('title',$exam->title,['class'=>'form-control','required'])}}
    </div>

     <div class="form-group">
       {{ Form::label('description', ' Descripiton(Opt) :') }}
       {{-- 这里使用了id加上api --}}
       {{ Form::textarea('description',$exam->description,['id'=>'article-ckeditor','class'=>'form-control']) }}
    </div>

    <div class="form-group">
      <label for="sel2">This exam belongs to:</label> <br>
        <label for="sel2">Current choose:  <b>{{ $exam->material->title }}</b></label>
      <select class="form-control" id="sel2" name="material_id" >
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title'] }}</option>  
            @endforeach
      </select>
    </div>

    <div class="form-group">
         {{ Form::label('marks', ' Enter marks* : ') }}
         <input type="number" class="form-control" name="marks" value="{{ $exam->marks }}"  required>
    </div>


    <div class="form-group" id="frmtest">
      <label for="exams_file"> Current File : {{ $exam->exams_file }}   <b class="text-warning"> (Please upload pdf file only! )</b></label> <br>
      {{ Form::file('exams_file') }}
    </div>
  
    {{ Form::hidden('_method','PUT') }}
    {{Form::submit('Update ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
    <a href="/exams/{{ $exam->id }}" class="btn btn-default">Cancel</a>
    {!! Form::close() !!}   

 
</div>

@endsection
