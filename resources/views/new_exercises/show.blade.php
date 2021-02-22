@extends('layouts.app')
@section('content')
@php
    use App\Answer;

    //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records中
    $records = Answer::where('user_id', '=', auth()->user()->id)
    ->where('exercise_id', '=', $exercise->id)->get();
    //用count()计数
    $recordCount = $records->count();

    $m_mcq = $exercise->mcq;
    /* //将转义后的双引号更改为空字符
    $m_mcq = str_replace('",null,null,nul','', $m_mcq); */
    
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




<div class="container text-center" id="new_exerciseme">

    <h3>this is new_exercises show</h3>
    

        @if ($h == 1)
        <div class="questionArea row">
            <div >
                <p>{{ $exercise->multiplier }}</p>
            </div>
            <p>&times</p>
            <div>
                <p>{{ $exercise->multiplicand }}</p>
            </div>
            <p>=</p>
            <div>
                <p>?</p>
            </div>
        </div>
        @elseif($h == 2)
        <div class="questionArea row">
            <div>
                <p>{{ $exercise->multiplier }}</p>
            </div>
            <p>&times</p>
            <div>
                <p>?</p>
            </div>
            <p>=</p>
            <div>
                <p>{{ $exercise->product }}</p>
            </div>
        </div>
        @else
        <div class="questionArea row">
            <div>
                <p>?</p>
            </div>
            <p>&times</p>
            <div>
                <p>{{ $exercise->multiplicand }}</p>
            </div>
            <p>=</p>
            <div>
                <p>{{ $exercise->product }}</p>
            </div>
        </div>
        @endif
    

    @if( $recordCount > 0 )
        <h3 class="text-success">You have already submitted an answer to this question.</h3>
        <h4>The Correct answer is </h4>
    <h4>{{ $correctAns }}</h4>
       
    
    @else
        {!! Form::open(['action'=> 'AnswersController@new_store','method'=>'POST']) !!}
        {{ csrf_field() }}
        
            <h4>What is your answer?</h4>
        @if ($cCount > 2)
        <select multiple class="form-control" id="sel2" name="answers[]" required>
            @foreach ($c as $singleC)
                <option value="{{ $singleC }}" name="answers[]" >{{ $singleC }}</option>
            @endforeach
        </select> 
        @else
        {{ Form::text('answers[]','',['class'=>'form-control', 'required'=>"required"]) }}
        @endif
        
        


        <input type="hidden" name="exercise_id" value="{{ $exercise->id }}" />

        <center><br>
        {{ Form::submit('Answer ',['class'=>'btn btn-primary uploadme']) }}
        {!! Form::close() !!}  
        <h2>The right answer is(This is only show for test) </h2>
        <p> {{ $correctAns }}</p>
        
        </center>
    
    @endif
    

</div>
@endsection