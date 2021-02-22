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

    .Iconme{
        width:20vh;
        position: relative;
        top: 0;
        animation: myMove 3s infinite;
        -webkit-animation: myMove 3s infinite;

    }

     @keyframes myMove {
        0% {
            top: 0px;
        }

        50% {
            top: 100px;
        }

        100% {
            top: 0px;
        }
    }

    @-webkit-keyframes myMove {
        0% {
            top: 0px;
        }

        50% {
            top: 100px;
        }

        100% {
            top: 0px;
        }
    }


    .Iconme img{
        width:100%;
        border-radius: 900px;
    }
</style>


@extends('layouts.app')
@section('content')
    

@php
    use App\Answer;
    use App\ActivityMark;

    //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records中
    $records = Answer::where('user_id', '=', auth()->user()->id)
    ->where('exam_id', '=', $exam->id)->get();
    //用count()计数
    $recordCount = $records->count();

    $file = $exam->exams_file;
    //将转义后的双引号更改为空支付
    //$file = substr($file,18);

    $countAnswer = $answers->count();


    
@endphp

<div class="container text-center justify-center-center" style="position: relative">

    <a href="/exams" class="goBack"><button class="btn btn-primary"><span class="material-icons" style="color: white; line-height:40px">first_page</span></button></a>
        
    <div class="Iconme">
        <img src="../storage/img/portfolio/background/icon3.png" alt="icon"> 
    </div>
    <br>

    @if (Auth::check())
        @if ($exam->user_id == auth()->user()->id || auth()->user()->type == 'Admin')
            <span style="float: right"><button class="btn" style="background-image: linear-gradient(to top, #fddb92 0%, #d1fdff 100%); "><a href="/exams/{{ $exam->id }}/edit">Edit</a></button> </span>
        @endif
    @endif

    <div style="margin-bottom: 5vh;">
        <h2 class="text-light "><b>{{ $exam->title }}</b><span> (Full mark:  {{ $exam->marks }})</span></h2>
    </div>
    <div style="height: 1000px; margin:20px; ">
        <embed src="/storage/exams_file/{!! $file !!}" type="application/pdf" style="width:100%; height:100%">
    </div>

    <a href="/storage/exams_file/{!! $file !!}" style="font-size: 20px;" download>{{ $exam->title }} ( Click to download this file)</a>
    <br>
    <h4 class="text-left">
        {{ $exam->description }}      
    </h4>
    <hr>
    
    <h3 class="text-light">Upload your answer here  <b class="text-warning">(Only one chance!!) </b> &emsp;&emsp;---Support pdf,doc,docx,text file</h3>

{{-- 如果数据库中回答同一个人回答记录记录>=1(即有回答记录，回答过一次了) 就不能回答了，只能看题目和答案 --}}
    @if( $recordCount > 0 )
        <h3 class="text-success">You have already submitted your answer to this question.</h3>
    @else
        {!! Form::open(['action'=> 'AnswersController@exam_answer','method'=>'POST','enctype'=>'multipart/form-data']) !!}
        {{ csrf_field() }}
        <input type="hidden" name="exam_id" value="{{ $exam->id }}" />
        <div class="form-group">
            {{ Form::file('answers_file',['required']) }}
        </div>
        {{ Form::submit('Answer ',['class'=>'btn btn-primary uploadme']) }}
        {!! Form::close() !!}  
    @endif
</div>

<hr>

@if (auth()->user()->type != 'Student' && $countAnswer > 0)
<div class="container">
    <h3 class="text-warning">Student Exercise Answer</h3>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Name</th>
                <th scope="col" title="click to view/download">Answer file <b class="text-success"></b></th>
                <th scope="col">Submit Time</th>
                <th scope="col">Give Mark <b class="text-danger">(Full Mark: {{ $exam->marks }})</b></th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($answers as $answer)
            <tr>
            <td>{{ $answer->user->name }}</td>
            <td title="click to view/download"><a href="/storage/answers_file/{!! $answer->answers_file !!}">{{ $answer->answers_file }}</a></td>
            <td>{{ $answer->created_at }}</td>
            <td>
                @php
                    //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records中
                    $records2 = ActivityMark::where('user_id', '=', $answer->user->id)
                    ->where('exam_id', '=', $exam->id)->get();
                    //用count()计数
                    $recordCount2 = $records2->count();
                @endphp

                @if ($recordCount2 < 1 )
                    {!! Form::open(['action'=> ['ActivityMarksController@assignMark'],'method'=>'POST' ]) !!}
                    <input type="number" name="activity_marks" style="display: inline-block" required>
                    <input type="hidden" name="user_id" value="{{ $answer->user->id }}">
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    {{ Form::submit('Give Mark',['class'=>'btn btn-danger input-group-btn','onclick'=>'return confirm("Are you sure to assign this mark?")']) }}
                    {!! Form::close() !!}  
                @else
                    <h4 class="text-warning">Mark Assigned</h4>
                @endif

        
            </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>      

@endif 
 





@endsection
