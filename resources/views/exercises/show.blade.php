
@extends('layouts.app')
@section('content')

@php
    use App\Answer;

    //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records
    $records = Answer::where('user_id', '=', auth()->user()->id)
    ->where('exercise_id', '=', $exercise->id)->get();
    //用count()计数
    $recordCount = $records->count();


    $question = $exercise->questions;
    $q = explode('","',trim($question));

    $a_answer = $exercise->correct_answers;
    $a = explode('","',trim($a_answer));
    
    $m_mcq = $exercise->mcq;
    $c = explode('","',trim($m_mcq));
    //记录有多少条数组值
    $qCount = count($q);
    $cCount = count($c);


    $e = array_chunk($c,3);
  
           
        
/* 

    测试数据
    $marks = 0;
    $mark = Exercise::where('id', '=', 29)->first('marks');
    $sub = substr($mark, 10, -2);
    $fullMark = explode('\",\"', trim($sub));

    $val = intval($fullMark[0]);
    echo $mark = $marks + $val; 
     echo gettype($marks), "\n"; */

@endphp



<div class="container center-block">
        <div class="text-center">
        <h3>Question here: </h3>
    @if ($qCount >=1)
    @foreach ($q as $singleQ)
        
        <h4>{{ $singleQ }}</h4>
    @endforeach
    @endif

    @if ($cCount >= 1)
    @foreach ($c as $singleC)
        <h4>{{ $singleC }}</h4>
    @endforeach
        
    @endif
    
        
    

    {{-- 如果数据库中回答同一个人回答记录记录>=1(回答过一次了) 就不能回答了，只能看题目和答案 --}}
    @if( $recordCount > 0 )
        <h3 class="text-success">You have already submitted an answer to this question.</h3>
        <h4>The Correct answer is </h4>
        @foreach ($a as $singleA)
              <h5> {{ $singleA }} </h5> 
        @endforeach
        

    @else
        {!! Form::open(['action'=> 'AnswersController@store','method'=>'POST']) !!}
        {{ csrf_field() }}
        @if( $qCount >=1 )
            @php
                $y = 0;
            @endphp
            @foreach($q as $singleQ)
            

            <div class="row">
                <div class="from-group col-6">
                    <h4>Question:</h4>
                    <h5> {{ $singleQ }} </h5>
                </div>
                <div class="form-group col-6">
                {{ Form::label('answers', ' Enter Your Answer* : ') }}

                @if ($cCount > 1)

                <select multiple class="form-control" id="sel2" name="answers[]" required>
                    @foreach ($e[$y] as $item)
                         <option value="{{ $item }}" name="answers[]" >{{ $item }}</option>  
                    @endforeach
                </select>
                @else
                    {{ Form::text('answers[]','',['class'=>'form-control', 'required'=>"required"]) }}
                @endif
                </div>
            </div>
            
            @php
                $y++;
            @endphp
            @endforeach
        @endif

        {{ Form::label('description', 'Description(Opt): ') }}
        {{ Form::text('description','',['class'=>'form-control']) }}


        <input type="hidden" name="exercise_id" value="{{ $exercise->id }}" />

        <center><br>
        {{ Form::submit('Answer ',['class'=>'btn btn-primary uploadme']) }}
        {!! Form::close() !!}  
        <h2>The right answer is </h2>
        <p> {{ $exercise->correct_answers }}</p>
        @foreach ($a as $singleA)
              <h5> {{ $singleA }} </h5> 
        @endforeach
        </center>
    
    @endif
    
    
</div>
</div>

@endsection