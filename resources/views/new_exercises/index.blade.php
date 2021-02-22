<style>
    .bg{
        background-image: linear-gradient(-225deg, #DFFFCD 0%, #90F9C4 48%, #39F3BB 100%);
        border-radius: 30px;
        padding: 4vh 2vw 0;
        margin: 2vh 0;
        position: relative;
    }

    .exerciseme h4{
        color: #EB984E !important;
    }

    .edit{
        position: absolute;
        top: 1rem;
        right: 2rem;
        font-size: 20px;
        color: orchid;
    }

    .title{
        color: orange;
    }

    .title small{
        color: #3498DB !important;
    }

    .title small{
        color: #CCFF66;
    }

</style>

@extends('layouts.app')
@section('content')

@php
use Carbon\Carbon;
@endphp


<div class="container materialsme exerciseme">
    <div class="row">
        @foreach ($exercises as $exercise)

        @php
            $m_mcq = $exercise->mcq;
            $c = explode('","',trim($m_mcq));

            $cCount = count($c);

            $m_mcq = $exercise->mcq;
            $c = explode('","',trim($m_mcq));

            $cCount = count($c);

            //用于判断显示问题
            $correctAns = 0;
            $h = $exercise->hide;
            if ($h == 1) {
                $correctAns = $exercise->product;
            }elseif ($h == 2) {
                $correctAns = $exercise->multiplicand;
            }else{
                $correctAns = $exercise->multiplier;
            }
        @endphp
            <div class="col-6">
                <div class="shadow-lg bg">
                    <br>
                    {{-- 问题部分 --}}
                    @if($h == 1)
                        <h3><span class="title">{{ $exercise->title }}<small>( Mark: {{ $exercise->marks }} )</small> : &emsp; </span> {{ $exercise->multiplier }} &times; {{ $exercise->multiplicand }} = ?</h3>
                    @elseif($h == 2)
                        <h3><span class="title">{{ $exercise->title }}<small>( Mark: {{ $exercise->marks }} )</small> : &emsp;</span> {{ $exercise->multiplier }} &times; ? = {{ $exercise->product }}</h3>
                    @else
                        <h3><span class="title">{{ $exercise->title }}<small>( Mark: {{ $exercise->marks }} )</small> : &emsp;</span> ? &times; {{ $exercise->multiplicand }} = {{ $exercise->product }}</h3>
                    @endif
                    @if ($cCount > 2)
                        <h4> <small>Question type : </small><span class="text-warning"> &nbsp;MCQ </span> <small>&emsp; Options: </small>[
                        @foreach ($c as $singleC)
                           <span class="text-warning">&nbsp;{{ $singleC }}&nbsp;</span>
                        @endforeach]</h4>    
                    @else
                        <h4> <small>Question type : </small><span class="text-info">Normal</span></h4>
                    @endif
                        <h4><small>Correct answer : </small> <span class="text-warning"> {{ $correctAns }}</span></h4>
                    <br>
                    <span class="text-info"><b>{{ $exercise->user->name }}</b>  ---{{ Carbon::parse($exercise['created_at'])->format('d M Y') }} </span>
                    {{-- edit标签 --}}
                    @if (!Auth::guest())
                        @if (Auth::user()->type !== "Student")
                            <a class="edit" href="/new_exercises/{{ $exercise->id }}/edit" id="edit">edit</a>
                        @endif
                    @endif
                    {{-- <p class="media-date"><i class="material-icons">update</i><b>{{ $exercise->created_at->diffForHumans() }}</b></p> --}}
                    
                </div>  
            </div>
        @endforeach
        
        <div class="col-12 d-flex justify-content-center " style="margin-top:5vh;">
            {{ $exercises->links() }}
        </div>
        
    </div>

        

    {{-- 上传新课件按钮 --}}
    @if (!Auth::guest())
        @if(Auth::user()->type !== 'Student')
        <div class="btnme">
        <p><a href="/new_exercises/create"> <span class="material-icons text-light" title="Create new question">control_point</span></a></p>
        {{-- <a class="upload" href="/new_exercises/create">Create</a> --}}
        </div>
        @endif
    @endif
        
    
</div>
@endsection