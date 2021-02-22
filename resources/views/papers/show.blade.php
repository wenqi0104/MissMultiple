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
        animation-name: happy;
        animation-delay: 2s;
        animation-duration: 6s;
        animation-fill-mode: forwards;

    }

    @keyframes happy{
        0%{
            transform:translateX(0);
        }
        100%{
            transform:translateX(100vh);
        }
    }

    .Iconme img{
        width:100%;
        border-radius: 900px;
    }


    .title{
        color: orange;
    }

    .title small{
        color: #adfd51;
        text-shadow: 2px 5px 8px rgba(0, 0, 0,0.2);
    }

    .input-group-btn{
        margin-left: auto;
    }

    .radio-inline span{
        margin-right: 10vh;
        font-size: 20px;
        line-height: 20px;
        vertical-align: middle;
    }


    
</style>
@extends('layouts.app')
@section('content')

@php
    use App\Answer;
    use App\New_Exercise;
    use App\Paper;



    $ex_id = $paper->new_exercise_id;
    $eid = explode('","',trim($ex_id));
    $eCount = count($eid);

    $Questions = New_Exercise::find($eid);  
    $fullMark =0;
    $questionsCount = 0;
    $questionsC = 0;
    //计算总分
    foreach ($Questions as $w) {
        $marks= (int)$w->marks;
        $fullMark = $marks + $fullMark;

        $questionsCount++;
    }

  /* //session赋值 然后传值
   session_start();
   $_SESSION['one']=$fullMark; */
  
@endphp


<div class="container">
    <a href="/papers" class="goBack"><button class="btn btn-primary"><span class="material-icons" style="color: white; line-height:40px">first_page</span></button></a>
        
    <div class="Iconme">
        <img src="../storage/img/portfolio/background/icon1.png" alt="icon"> 
    </div>
    <br>

    @if (Auth::check())
        @if ($paper->user_id == auth()->user()->id || auth()->user()->type == 'Admin')
            <span style="float: right"><button class="btn" style="background-image: linear-gradient(to top, #fddb92 0%, #d1fdff 100%); "><a href="/papers/{{ $paper->id }}/edit">Edit</a></button> </span>
        @endif
    @endif
    <div class="text-center" style="margin-bottom: 5vh;">
        <h2 class="text-light "><b>{{ $paper->title }}</b><span> ({{ $fullMark }} Marks)    &emsp;&emsp;---{{ $questionsCount }} quesitons </span></h2>
    </div>
    

    @if ( $eCount > 0 )
        {{-- foreach里的内容就是练习册里的所有问题的信息！！！！！ --}}
        @foreach ($Questions as $q)
            @php
                $m_mcq = $q->mcq;
                $c = explode('","',trim($m_mcq));

                $cCount = count($c);
                ++$questionsC;

                //用于判断显示问题
                $correctAns = 0;
                $h = $q->hide;
                if ($h == 1) {
                    $correctAns = $q->product;
                }elseif ($h == 2) {
                    $correctAns = $q->multiplicand;
                }else{
                    $correctAns = $q->multiplier;
                }

                
                //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records中
                $records = Answer::where('user_id', '=', auth()->user()->id)
                ->where('exercise_id', '=', $q->id)->get();
                //用count()计数
                $recordCount = $records->count();
                
                $fullmark = 0;
                $m=(int)$q->marks;
            @endphp


            
            <div class="row">
                <div class="col-5">
                    {{-- 问题部分 --}}
                    @if ($h == 1)
                        <h3><span class="title"> Q{{ $questionsC }}<small>( Mark: {{ $q->marks }} )</small> : &emsp; </span> {{ $q->multiplier }} &times; {{ $q->multiplicand }} = ?</h3>
                    @elseif($h == 2)
                        <h3><span class="title"> Q{{ $questionsC }}<small>( Mark: {{ $q->marks }} )</small> : &emsp;</span> {{ $q->multiplier }} &times; ? = {{ $q->product }}</h3>
                    @else
                        <h3><span class="title"> Q{{ $questionsC }}<small>( Mark: {{ $q->marks }} )</small> : &emsp;</span> ? &times; {{ $q->multiplicand }} = {{ $q->product }}</h3>
                    @endif
                </div>
                <div class="col-7">
                    @if( $recordCount > 0 )
                        <h3 ><span class="text-warning">Question answered. </span>  <span style="color:#60F8A9;  background-color:rgba(0, 0, 0,0.1); border-radius: 20em; padding: 0 7px;">Correct answer: <b>{{ $correctAns }}</b></span> </h3>
                        <div>
                            <a href="#demo" class="btn btn-info text-light" data-toggle="collapse">Report</a>
                            <div id="demo" class="collapse">
                                @foreach ($records as $record)
                                    {!! Form::open(['action'=> ['AnswersController@update',$record->id],'method'=>'POST']) !!}
                                    @csrf
                                    <textarea name="description" cols="40" rows="3"></textarea>
                                    {{ Form::hidden('_method','PUT') }}
                                    {{ Form::submit('Send Feedback',['class'=>'btn btn-warning']) }}
                                    {!! Form::close() !!}
                                @endforeach
                            </div>
                        </div>

                        <hr>
                    @else
                        {!! Form::open(['action'=> 'AnswersController@new_store', 'method'=>'POST','class'=>'input-group']) !!}
                        {{ csrf_field() }}
                        @if ($cCount > 2)
                            {{-- <select class="form-control" id="sel2" name="answers[]" required>
                                @foreach ($c as $singleC)
                                    <option value="{{ $singleC }}" name="answers[]" >{{ $singleC }}</option>
                                @endforeach
                            </select>  --}}
                            @foreach ($c as $singleC)
                                <label class="radio-inline">
                                    <input type="radio" name="answers[]" id="optionsRadios3" value="{{ $singleC }}" required> <span>{{ $singleC }}</span>         
                                </label>
                            @endforeach
                        @else
                            {{-- {{ Form::text('answers[]','',['class'=>'form-control ', 'required'=>"required"]) }} --}}
                            <input type="number" name="answers[]" class="form-control"  required>
                        @endif
                        <input type="hidden" name="exercise_id" value="{{ $q->id }}" />
                        {{ Form::submit('Answer ',['class'=>'btn btn-primary input-group-btn']) }}
                        {!! Form::close() !!} 
                    @endif 
                </div>
            
                    
            </div>

            

        @endforeach
    @endif
</div>
@endsection