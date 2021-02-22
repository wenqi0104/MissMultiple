@extends('layouts.app')
@section('content')

@php
   use App\New_Exercise;

    $ex_id = $paper->new_exercise_id;
    $eid = explode('","',trim($ex_id));
    $Questions = New_Exercise::find($eid);  
@endphp



<div class="container">
   <h1 class="text-light text-center" style="margin-top: 2vh;">Edit & Update Exercise Book : <span class="text-warning"> {{ $paper->title }} </span></h1>
   {!! Form::open(['action'=> ['PapersController@update',$paper->id],'method'=>'POST']) !!}
    {{ csrf_field() }}
   <div class="form-group">
      {{ Form::label('title', ' Title :') }}
      {{ Form::text('title',$paper->title,['class'=>'form-control']) }}
   </div>

   <div class="form-group">
   <label for="sel2">This exam belongs to(Choose one only) :  </label>
   <label for="sel2" >Current choose:  <b>{{ $paper->material->title }}</b></label>
      <select class="form-control" id="sel2" name="material_id"  >
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title']}}</option>  
            @endforeach
      </select>
   </div>
   <div class="form-group">
      <label for="sel2">Choose the questions to include : (Hold shift to choose multiple quesitons) </label> <br>
      <label for="sel2">Current choose : [<b>
         @foreach ($Questions as $q)
            &emsp;{{ $q->title }}&emsp;
         @endforeach
         </b>]</label>
      <select multiple class="form-control" id="sel2" name="new_exercise_id[]" style="height: 20vh;" >
            @foreach ($new_exercises as $new_exercise)
             <option value="{!! $new_exercise['id'] !!}" name="new_exercise_id[]" >{{ $new_exercise['title']}}</option>  
            @endforeach
      </select>
   </div>


    {{ Form::hidden('_method','PUT') }}
    {{ Form::submit('Update ',['class'=>'btn btn-primary','id'=> 'uploadme']) }}
    <a href="/papers/{{ $paper->id }}">Cancel</a>
    {!! Form::close() !!}   
    
    

    {{-- @if (!Auth::guest())
    @if(Auth::user()->id == $paper->user_id || Auth::user()->type == "Admin" )
            {!! Form::open(['action'=> ['PapersController@destroy',$paper->id],'method'=>'POST', 'class'=>'pull-right' ]) !!}
            {{ Form::hidden('_method','DELETE') }}
            {{ Form::submit('Delete',['class'=>'btn btn-danger']) }}
            {!! Form::close() !!}  
            @endif
    @endif --}}
</div>
@endsection