@extends('layouts.app')
@section('content')

<div class="container">
    <h2 class="text-light text-center" style="margin-top: 2vh;">Upload New Course Material</h2>
    {{-- 提交（POST）到存储方法中，若要提交图片，要额外注明enctype --}}
   {!! Form::open(['action'=> 'MaterialsController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
   {{ csrf_field() }}
    <div class="form-group">
       {{ Form::label('title', ' Title :') }}
      {{--  第一个值是key,第二个是默认值,后面还可以指定属性 --}}
       {{Form::text('title','',['class'=>'form-control','required'])}}
    </div>
    <div class="form-group">
       {{ Form::label('description', ' Descripiton :') }}
       {{-- 这里使用了id加上api --}}
       {{ Form::textarea('description','',['id'=>'article-ckeditor','class'=>'form-control']) }}
    </div>
  {{-- 图片的上传部分 --}}
    <label for="image">Upload images here : <b>( Suppurt for jpeg,png,jpg,gif,svg, maximum size: 2MB )</b></label> <br>
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
   <hr>

      {{-- 视频的上传部分 --}}
      {{-- 在axampp中重新设置了上传文件的大小上限， 在实际服务器中可能也要设置上传文件上限
      memory_limit= 128M       改为了  500M
      post_max_size= 8M        改为了  500M
      upload_max_filesize= 2M  改为了  500M
      --}}


    <div class="form-group">
      <label for="file">Upload video here : <b>( Suppurt for mp4,mov,ogg,qt video, maximum size: 70MB )</b></label><br>
      {{ Form::file('uploads') }}
    </div>
    
    {{Form::submit('Upload ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
    <a href="/materials" class="btn btn-default">Cancel</a>
    {!! Form::close() !!}   

</div>


@endsection



