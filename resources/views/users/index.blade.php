@extends('layouts.app')
@section('content')


@if (count($users)>0)

    <div class="container" id="userme">

        <h3>Students</h3>
        <table class="table">
            <thead class="thead-light">
                <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Age</th>
                <th scope="col">Gender</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                <th scope="col">Activity Mark</th>
                </tr>
            </thead>
        <tbody>
            @foreach ($students as $student)
       
                <tr>
                    <td><a href="/users/{{ $student->id }}">   {{ $student->id }} </a></td> 
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->age }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->created_at }}</td>
                    <td>{{ $student->type }}</td>
                    <td>活动分</td>
                    <td>    
                        {!! Form::open(['action'=> ['UsersController@destroy',$student->id],'method'=>'POST' ]) !!}
                        {{ Form::hidden('_method','DELETE') }}
                        <a href="/users/{{ $student->id }}/edit" class="btn btn-default"> Edit </a>
                        {{ Form::submit('Delete',['class'=>'btn btn-danger']) }}
                        {!! Form::close() !!}  
                    </td>  
                </tr>
                
            @endforeach 
        </tbody>
        </table>
                
    </div>



    <hr>
    <div class="container" id="userme">

        <h3>Staff & Admin</h3>
        <table class="table">
            <thead class="thead-light">
                <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Age</th>
                <th scope="col">Gender</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                <th scope="col">Activity Mark</th>
                </tr>
            </thead>
        <tbody>
            @foreach ($managers as $manager)
                <tr>
                    <td> <a href="users/{{ $manager->id }}">{{ $manager->id }}</a> </td>
                    <td>{{ $manager->name }}</td>
                    <td>{{ $manager->email }}</td>
                    <td>{{ $manager->age }}</td>
                    <td>{{ $manager->gender }}</td>
                    <td>{{ $manager->created_at }}</td>
                    <td>{{ $manager->type }}</td>
                    <td>活动分</td>
                    <td>    
                        {!! Form::open(['action'=> ['UsersController@destroy',$manager -> id],'method'=>'POST' ]) !!}
                        {{ Form::hidden('_method','DELETE') }}
                        <a href="/users/{{ $manager -> id }}/edit" class="btn btn-default"> Edit </a>
                        {{ Form::submit('Delete',['class'=>'btn btn-danger']) }}
                        {!! Form::close() !!}  
                    </td>  
                </tr>
            @endforeach 
        </tbody>
        </table>
                
    </div>


@endif




<div class="materialsme">

    @if (!Auth::guest())
        {{-- @if(Auth::user()->id == $exercise->user_id) --}}
        {{-- 判断用户类型，如果用户的类型是...就显示upload按钮 --}}
        @if(Auth::user()->type == 'Admin')
        <div class="btnme">
        <p><a href="/users/create"> <span class="material-icons">control_point</span></a></p>
        <a class="upload" href="/papers/create">Create</a>
        </div>
        @endif
    @endif

</div>



@endsection