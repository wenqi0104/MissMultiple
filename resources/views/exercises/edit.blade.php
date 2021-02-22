@extends('layouts.app')
@section('content')


@php
    $question = $exercise->questions;
    $q = explode('","',trim($question));

    $a_answer = $exercise->correct_answers;
    $a = explode('","',trim($a_answer));

    $m_mark = $exercise->marks;
    $m = explode('","',trim($m_mark));
    
    $c_mcq = $exercise->mcq;
    $c = explode('","',trim($c_mcq ));

    $e = array_chunk($c,3);

    //记录有多少条数组值
    $qCount = count($q);
    $cCount = count($c);
@endphp


<h1>Edit and Update Exercise</h1>

<div class="container">
   {!! Form::open(['action'=> ['ExercisesController@update',$exercise -> id],'method'=>'POST']) !!}
    {{csrf_field()}}
   <div class="form-group">
      {{ Form::label('title', ' Title :') }}
      {{ Form::text('title',$exercise->title,['class'=>'form-control']) }}
   </div>

   <div class="form-group">
      <label for="sel2">This exercise belongs to: </label>
      <select multiple class="form-control" id="sel2" name="material_id" required >
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title'],$exercise -> material_id }}</option>  
            @endforeach
      </select>
   </div>


   {{-- 当问题和所属的正确答案，分数大于等于1 时，循环一个数值（因为我这里的所有属性个数都是一样的） --}}
  @if ($qCount >=1 )
   {{-- 全局变量i，指的是目前循环的次数，每执行一次，在底下+1， 然后再blade中直接输出数组【i】就是当次循环的数值 --}}
         @php
            $y = 0;
         @endphp

      @foreach ($q as $singleQ)
      <div class="row input-group control-group increment">
         
         
         <div class="form-group col-4">
            {{ Form::label('questions', ' Question here* : ') }}
            {{ Form::text('questions[]',$singleQ,['class'=>'form-control','required']) }}
         </div>
         
         <div class="form-group col-4">
            {{ Form::label('correct_answers', ' Enter Correct Answers* : ') }}
            {{ Form::text('correct_answers[]',$a[$y],['class'=>'form-control','required']) }}
         </div>
         
         <div class="form-group col-4">
            {{ Form::label('marks', ' Enter marks* : ') }}
            {{ Form::text('marks[]',$m[$y],['class'=>'form-control','required']) }}
         </div>

         @if ($cCount > 1)
             @foreach ($e[$y] as $item)
             <div class="row">
            {{ Form::label('options', ' Enter options : ') }}
            {{ Form::text('mcq[]',$item,['class'=>'form-control']) }}
            </div>
             @endforeach
         @endif


         @php
            $y++;
         @endphp

         <div class="input-group-btn">
            <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
         </div>
          <div class="input-group-btn"> 
            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
         </div>
      
      </div>
      @endforeach
  @endif

  

    <div class="row clone hide">
      <div class="control-group input-group" style="margin-top:10px">

         <div class="form-group col-4">
         {{ Form::label('questions', ' Question here* : ') }}
         {{Form::text('questions[]','',['class'=>'form-control','required'])}}
         </div>
         <div class="form-group col-4">
         {{ Form::label('correct_answers', ' Enter Correct Answers* : ') }}
         {{Form::text('correct_answers[]','',['class'=>'form-control','required'])}}
         </div>
         <div class="form-group col-4">
         {{ Form::label('marks', ' Enter marks* : ') }}
         {{Form::text('marks[]','',['class'=>'form-control','required'])}}
         </div>

         <div class="input-group-btn"> 
            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
         </div>
      </div>
    </div>



  
      {{ Form::hidden('_method','PUT') }}
      {{ Form::submit('Update ',['class'=>'btn btn-primary','id'=> 'updateme']) }}
      {!! Form::close() !!}   
      <a href="/exercises"> <button class="btn btn-default">Cancel</button></a>
    

    @if (!Auth::guest())
    @if(Auth::user()->id == $exercise->user_id || Auth::user()->type == "Admin" )
            {!! Form::open(['action'=> ['ExercisesController@destroy',$exercise -> id],'method'=>'POST', 'class'=>'pull-right' ]) !!}
            {{ Form::hidden('_method','DELETE') }}
            {{ Form::submit('Delete',['class'=>'btn btn-danger']) }}
            {!! Form::close() !!}  
            @endif
    @endif
</div>




 
@endsection