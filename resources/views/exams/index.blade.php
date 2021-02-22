<style>
    .bg{
        background-image: linear-gradient(to top, #bdc2e8 0%, #bdc2e8 1%, #e6dee9 100%);
        border-radius: 30px;
        padding: 4vh 2vw 0;
        margin: 2vh 0;
        position: relative;
    }

    .edit{
        position: absolute;
        top: 2rem;
        right: 3rem;
        font-size: 20px;
        color: sienna;
    }
</style>


@extends('layouts.app')
@section('content')

@php
//  php的 session传值用法
//     session_start();
//    $fullmark = $_SESSION['one'];
use Carbon\Carbon;
@endphp


<div class="container materialsme">
    <div class="row">
        @foreach ($exams as $exam)
            <div class="col-6">
                <div class="shadow-lg bg">
                    <h4><a href="/exams/{{ $exam->id }}">{{ $exam->title }}</a></h4><br>
                    <span class="text-right">Created by: {{ $exam->user->name }}</span>
                    {{-- edit标签 --}}
                    @if (!Auth::guest())
                        @if (Auth::user()->id == $exam->user_id || Auth::user()->type == "Admin")
                            <a class="edit" href="/exams/{{ $exam->id }}/edit" id="edit">edit</a>
                        @endif
                    @endif
                    <p class="media-date"><i class="material-icons">update</i><b>{{ $exam->created_at->diffForHumans() }}</b> --- <span> {{ Carbon::parse($exam['created_at'])->format('d M Y') }}</span></p>
                    <br>     
                </div>  
            </div>
        @endforeach
        
        <div class="col-12 d-flex justify-content-center " style="margin-top:5vh;">
            {{ $exams->links() }}
        </div>
        
    </div>

        

    {{-- 上传新课件按钮 --}}
    @if (!Auth::guest())
        {{-- @if(Auth::user()->id == $exercise->user_id) --}}
        {{-- 判断用户类型，如果用户的类型是...就显示upload按钮 --}}
        @if(Auth::user()->type !== 'Student')
        <div class="btnme">
        <p><a href="/exams/create"> <span class="material-icons">control_point</span></a></p>
        <a class="upload" href="/exams/create">Create</a>
        </div>
        @endif
    @endif
        
    
</div>
@endsection