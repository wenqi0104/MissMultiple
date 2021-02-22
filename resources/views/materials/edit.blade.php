@extends('layouts.app')
@section('content')

@php
    //去除属性中两头的中括号
   $imageName = substr($material->images,2,-2);
   //将转义后的双引号更改为空支付
   $imageName = strtr($imageName,"\"", " ");
   //将剩下的内容分隔为当数值然后存入数组中  explod（）方法直接就会变为数组
   $imageName = explode(' , ',trim($imageName));

   $iCount = count($imageName);
   $z = 0;

@endphp




<div class="container">
<h1 class="text-light text-center" style="margin-top: 2vh;">Edit & Update Course Material : <span class="text-warning"> {{ $material->title }} </span></h1>

   {!! Form::open(['action'=> ['MaterialsController@update',$material->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}
   {{csrf_field()}}
   <div class="form-group">
      {{ Form::label('title', ' Title :') }}
   {{--  第一个值是key,第二个是默认值,后面还可以指定属性 --}}
      {{Form::text('title',$material->title,['class'=>'form-control'])}}
   </div>
   <div class="form-group">
      {{ Form::label('description', ' Descripiton :') }}
      {{-- 这里使用了id加上api --}}
      {{ Form::textarea('description',$material->description,['id'=>'article-ckeditor','class'=>'form-control']) }}
   </div>



   @if ($iCount >= 1)
      @foreach ($imageName as $singleI)
      <label for="imagename"> Current image: {{ $singleI }}<b> ( Suppurt for jpeg,png,jpg,gif,svg, maximum size: 2MB )</b></label>
      
      <div class="input-group control-group increment" >
         
         <input type="file" name="images[]" class="form-control" id="Image" onchange="image_preview()">
         <div class="input-group-btn">
         <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
         </div>
      </div>
      <div class="clone d-none">
         <div class="control-group input-group" style="margin-top:10px">
            <input type="file" name="images[]" class="form-control" id="Image" onchange="image_preview()">
            <div class="input-group-btn"> 
               <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div id="image_preview" class="col-3"></div>
         </div>
      </div>
      @endforeach
   <hr>
   @endif



   <div class="form-group">
       <label for="imagename"> Current File: {{ $material->uploads }} <b>( Suppurt for mp4,mov,ogg,qt video, maximum size: 70MB )</b></label> <br>
       {{ Form::file('uploads') }}
    </div>

   {{ Form::hidden('_method','PUT') }}
   {{ Form::submit('Update ',['class'=>'btn btn-warning','id'=> 'uploadme']) }}
   {{-- 返回按钮 --}}
   <a href="/materials/{{ $material->id }}" class="link" >Cancel</a>
   {!! Form::close() !!}   
    

{{-- @if (!Auth::guest())
   @if(Auth::user() == $material->user)
        {!! Form::open(['action'=> ['MaterialsController@destroy',$material->id],'method'=>'POST', 'class'=>'pull-right' ]) !!}
        {{ Form::hidden('_method','DELETE') }}
        {{ Form::submit('Delete',['class'=>'btn btn-danger']) }}
        {!! Form::close() !!}  
        @endif
@endif --}}

</div>   

@endsection

