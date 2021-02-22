<style>
     .contatiner{
        position: relative;
        overflow: hidden;
    }

    .goBack{
        position: absolute;
        top: 8vh;
        right: 5vh;

    }
</style>

@extends('layouts.app')
@section('content')
@php
    if (Auth::check()){
        $id = Auth::user()->id;
    }
@endphp
       
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center"> 
            
                     {{-- 返回按钮 --}}
            {{-- <a href="/users/{{ $user->id }}" class="justify-content-start"> <button class="btn btn-default">Go back</button></a> --}}
            <a href="/users/{{ $user->id }}" class="goBack"><button class="btn btn-primary"><span class="material-icons" style="color: white; line-height:40px">first_page</span></button></a>

            <div class="col-xl-12 col-md-12 col-lg-10">
                <div class="card user-card-full">
                    {!! Form::open(['action'=> ['UsersController@update',$user->id],'method'=>'POST','enctype'=>'multipart/form-data','style'=>'margin-bottom:0;']) !!}
                    @csrf
                    <div class="row m-l-0 m-r-0">
                       
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> 
                                    <h5>Current avatar</h5>
                                    <img src="/storage/img/{{ $user['avatar']}}" class="img-radius" style="width: 70px" alt="User-Profile-Image"> 
                                </div>
                                 {{-- 图片上传于预览 --}}
                                <div class="m-b-25" >
                                    {{ Form::file('avatar',['id'=>'Image','onchange'=>'image_preview()']) }} 
                                    <div id="image_preview" style="width: 120px height:120px;">
                                    </div>
                                </div>
                                
                                <h6 >
                                {{ Form::text('name',$user->name ,['style'=>'width:100%; text-align:center;background-color:transparent;' ]) }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400">
                                           {{ $user->email }}
                                        </h6>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Gender</p>
                                        <p>Current Gender: <span class="text-muted f-w-400">{{ $user->gender }}</span> </p>
                                        {{-- 字体灰色 --}}
                                        <h6 class="text-muted f-w-400">
                                        {{ Form::label('gender2', 'Male') }}    
                                        {{ Form::radio('gender', 'Male' , true) }}     {{-- 这行里的Male是输入进db的value --}}

                                        {{ Form::label('gender3', 'Female') }}  
                                        {{ Form::radio('gender', 'Female') }}
                                        </h6>
                                    </div>
                                </div>
                               <br/>
                               <br/>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">age</p>
                                        <p>Current Age: <span class="text-muted f-w-400">{{ $user->age }}</span> </p>
                                        <h6 class="text-muted f-w-400">
                                             {{ Form::number('age',$user->age) }}
                                        </h6>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="m-b-12 f-w-600">User type</p>
                                        <p>Current Type: <span class="text-muted f-w-400">{{ $user->type }}</span> </p>
                                        @if (Auth::user()->type !== 'Admin')
                                        <input type="hidden" name="type" value=" {{ $user->type }}">
                                        @else
                                            {{ Form::label('type2', 'Student') }}    
                                            {{ Form::radio('type', 'Student')}}
                                            <br>
                                            {{ Form::label('type3', 'Staff') }}  
                                            {{ Form::radio('type', 'Staff')}}
                                        <br>
                                            {{ Form::label('type4', 'Admin') }}  
                                            {{ Form::radio('type', 'Admin') }}
                                        @endif
                                    </div>

                                <input type="hidden" name="status" value="{{ $user->status }}">

                                {{-- 这是用于更改用户状态的按钮，点击直接submit状态
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">User Status</p>
                                        <h6 class="text-muted f-w-400">
                                            {{ $user -> status }}
                                        </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        @if($user->status == 'Unblocked')
                                            <input name="status" value="Blocked" type="hidden">
                                            <button type="submit" class="btn btn-danger">Block</button>
                                        @else
                                            <input name="status" value="Unblocked" type="hidden">
                                            <button type="submit" class="btn btn-primary">Unblock</button>
                                        @endif
                                    </div>
                                </div>
                                 --}}

                                
                                {{ Form::hidden('_method','PUT') }}
                                {{ Form::submit('Save change',['class'=>'btn btn-primary','id'=>'saveme']) }}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}  
                </div>
            </div>
        </div>
    </div>
</div> 
</div> 


@endsection