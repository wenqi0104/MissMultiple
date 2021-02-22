@extends('layouts.app')
@section('content')
    <h2>Create New Exercise MCQ</h2>
    {{-- 提交（POST）到存储方法中，若要提交图片，要额外注明enctype --}}
   {!! Form::open(['action'=> 'ExercisesController@storeMcq','method'=>'POST','enctype'=>'multipart/form-data']) !!}
   {{ csrf_field() }}
    <div class="form-group">
       {{ Form::label('title', ' Title :') }}
      {{-- 第一个值是key,第二个是默认值,后面还可以指定属性 --}}
       {{Form::text('title','',['class'=>'form-control'])}}
    </div>
    <div class="form-group">
      <label for="sel2">This exercise belongs to:</label>
      <select multiple class="form-control" id="sel2" name="material_id" required>
            @foreach ($materials_id as $material_id)
             <option value="{!! $material_id['id'] !!}" name="material_id" >{{ $material_id['title'] }}</option>  
            @endforeach
      </select>
    </div>
   
<div class="container">


        <div class="input-group row">
            <div class="col-4">
                <label for="question">Question here*</label>
                <input type="text" name="questions[]" class="form-control" required>
            </div>
            <div class="col-4">
                <label for="correct_answers">Enter Correct Answer*</label>
                <input type="text" name="correct_answers[]" class="form-control" required>
            </div>
            <div class="col-4">
                <label for="marks">Enter Marks*</label>
                <input type="text" name="marks[]" class="form-control" required>
            </div>
        </div>

        <div class="input-group control-group increment" >
            <div class="col-4">
                    <label for="mcq">Options</label>
                    <input type="text" name="mcq[]" class="form-control" required>
                    <button class="btn btn-primary btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add option</button>
            </div>    
        </div>
        <div class="clone ">
            <div class="control-group input-group" style="margin-top:10px">
                <div class="col-4">
                    <label for="mcq">Options</label>
                    <input type="text" name="mcq[]" class="form-control" required>
                    <button class="btn btn-warning btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i>Remove option</button>
                </div>
            </div>
        </div>
        



{{-- 
    <div class="input-group control-group form-group increment">
        <div class="input-group row">
            <div class="col-4">
                <label for="question">Question here*</label>
                <input type="text" name="questions[]" class="form-control" required>
            </div>
            <div class="col-4">
                <label for="correct_answers">Enter Correct Answer*</label>
                <input type="text" name="correct_answers[]" class="form-control" required>
            </div>
            <div class="col-4">
                <label for="marks">Enter Marks*</label>
                <input type="text" name="marks[]" class="form-control" required>
            </div>
        </div>

        <div class="input-group row">
            <div class="input-group control-group2 increment2" >
               
                    <div class="col-4">
                            <label for="mcq">Options</label>
                            <input type="text" name="mcq[]" class="form-control" required>
                            <button class="btn btn-primary btn-success2" type="button"><i class="glyphicon glyphicon-plus"></i>Add option</button>
                    </div>
                
            </div>
            <div class="clone2 d-none">
                <div class="control-group2 input-group" style="margin-top:10px">
                    
                        <div class="col-4">
                            <label for="mcq">Options</label>
                            <input type="text" name="mcq[]" class="form-control" required>
                            <button class="btn btn-warning btn-danger2" type="button"><i class="glyphicon glyphicon-remove"></i>Remove option</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
        <div class="input-group">
            <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
        </div>

    </div>


    <div class="clone d-none">
        <div class="control-group input-group" style="margin-top:10px">
            <div class="input-group row">
                <div class="col-4">
                    <label for="question">Question here*</label>
                    <input type="text" name="questions[]" class="form-control" required>
                </div>
                <div class="col-4">
                    <label for="correct_answers">Enter Correct Answer*</label>
                    <input type="text" name="correct_answers[]" class="form-control" required>
                </div>
                <div class="col-4">
                    <label for="marks">Enter Marks*</label>
                    <input type="text" name="marks[]" class="form-control" required>
                </div>
            </div>

            <div class="input-group row">
                <div class="input-group control-group3 increment3" >
                    <div class="col-4">
                    <label for="mcq">Options*</label>
                            <input type="text" name="mcq[]" class="form-control" required>
                            <button class="btn btn-primary btn-success3" type="button"><i class="glyphicon glyphicon-plus"></i>Add option</button>
                    </div>
                </div>
                <div class="clone3 d-none">
                    <div class="control-group3 input-group" style="margin-top:10px">
                        <div class="col-4">
                            <label for="mcq">Options****</label>
                            <input type="text" name="mcq[]" class="form-control" required>
                            <button class="btn btn-warning btn-danger3" type="button"><i class="glyphicon glyphicon-remove"></i>Remove option</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group-btn"> 
                <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
            </div>
        </div>
    </div>

 --}}
        




    

    {{Form::submit('Create ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
    {!! Form::close() !!}   
   
  </div>  


  <script>
       $(document).ready(function() {

        $(".btn-success3").click(function(){ 
          var html = $(".clone3").html();
          $(".increment3").after(html);
        });


        $("body").on("click",".btn-danger3",function(){ 
          $(this).parents(".control-group3").remove();
        });

    });
  </script>

@endsection



