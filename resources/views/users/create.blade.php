@extends('layouts.app2')
@section('content')
 

<div class="container">


<h3>Create New User</h3>
{!! Form::open(['action'=> 'UsersController@store','method'=>'POST']) !!}
{{csrf_field()}}
<div class="form-group">
 <label for="name1">Name *</label>
 <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
  </div>
  <input type="text" id="name1" name="name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required>
</div>
</div>


<div class="form-group">
    <label for="email">Email *</label>
<div class="input-group mb-3">
  <input type="email" id="email1" name="email" class="form-control" required>
  <div class="input-group-append">
    <span class="input-group-text" id="email1">@gmail.com</span>
  </div>
</div>
</div>
  


<div class="form-group">
    <label for="password1">Password *</label>
<div class="input-group mb-3">
  <div class="input-group-append">
    <span class="input-group-text" id="password1">minimum 8 letters</span>
  </div>
  <input id="password1" name="password" class="form-control" required>
</div>
</div>







<div class="form-group">
    <label for="age1">Age</label>
<div class="input-group mb-3">
  <div class="input-group-append">
    <span class="input-group-text" id="age1">Between 0~50</span>
  </div>
  <input id="age1" name="age" class="form-control">
</div>
</div>



<div class="form-group">
<p>Gender</p>
{{ Form::label('gender', 'Male') }}    
{{ Form::radio('gender', 'Male' , true) }}

{{ Form::label('gender', 'Female') }}  
{{ Form::radio('gender', 'Female') }}
</div>
  



<div class="form-group">
    <label for="type1">User Type</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text" for="type1">Type</label>
  </div>
  <select class="custom-select" name="type" required>
    <option value="Student" selected>Student</option>
    <option value="Staff">Staff</option>
    <option value="Administrator">Administrator</option>
  </select>
</div>
</div>


<input name="status" value="Unblocked" type="hidden">

 {{Form::submit('Create ',['class'=>'btn btn-primary','id'=> 'uploadme'])}}
 <a href="/admin" class="btn btn-default">Cancel</a>
 {!! Form::close() !!}   
   

</div>


@endsection