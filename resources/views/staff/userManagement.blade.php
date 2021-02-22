@extends('layouts.app2')
@section('content')

@php
    use App\User;
    use App\ActivityMark;
    $users = User::all();
    $students = User::where('type','Student')->get();
    $managers = User::where('type','Staff')->orderBy('type','desc')->get();

    /* 在点击用户活动分数列跳转新页面显示得分记录 */
@endphp



@if (count($users)>0)

    <div class="container-fluid" id="userme">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Students</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-info">
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date</th>
                                <th scope="col">Type</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Activity Mark</th>
                                <th scope="col" class="td-actions text-center">Manage User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                @php
                                $totalMark = 0 ;
                                //计算活动分数
                                $usersMark = ActivityMark::where('user_id',$student->id)->pluck('activity_marks');
                                foreach ($usersMark as $Marks) {
                                        $totalMark = $totalMark+$Marks;
                                }
                                @endphp
                                    <tr>
                                        <td>{{ $student->id }}</td> 
                                        <td><a href="/users/{{ $student->id }}"> {{ $student->name }} </a></td>
                                        <td><a href="/email/{{ $student->id }}"> {{ $student->email }}</a></td>
                                        <td>{{ $student->created_at }}</td>
                                        <td>{{ $student->type }}</td>
                                        <td>{{ $student->status }}</td>
                                        <td class="text-center"> <a href="/records/{{ $student->id }}">{{ $totalMark }}</a></td>
                                        <td class="td-actions text-center"> 
                                            {!! Form::open(['action'=> ['UsersController@destroy',$student->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                                            {{ Form::hidden('_method','DELETE') }}
                                            <a href="/users/{{ $student->id }}/edit" ><button type="button" rel="tooltip" class="btn btn-info btn-round"> Edit</button></a>
                                            <button type="submit" rel="tooltip" class="btn btn-danger btn-round">Delete</button>
                                            {!! Form::close() !!}       

                                            {!! Form::open(['action'=> ['UsersController@update',$student->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                            {{ csrf_field() }}
                                                
                                                    @if($student->status == 'Unblocked')
                                                        <input name="status" value="Blocked" type="hidden">
                                                        <button type="submit"  rel="tooltip" class="btn btn-warning btn-round">Block</button>
                                                    @else
                                                        <input name="status" value="Unblocked" type="hidden">
                                                        <button type="submit" rel="tooltip" class="btn btn-primary btn-round">Unblock</button>
                                                    @endif
                                                <input type="hidden" name="name" value="{{$student->name}}">
                                                <input type="hidden" name="age" value="{{$student->age}}">
                                                <input type="hidden" name="gender" value="{{$student->gender}}">
                                                <input type="hidden" name="type" value="{{$student->type}}">
                                            {{ Form::hidden('_method','PUT') }}
                                            {!! Form::close() !!}         
                                        </td>  
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                
    


    
            <div class="col-12" >
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Staffs</h4>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-info">
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date</th>
                                <th scope="col">Type</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Activity Mark</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($managers as $manager)
                                @php
                                $totalMark = 0 ;
                                //计算活动分数
                                $usersMark = ActivityMark::where('user_id',$manager->id)->pluck('activity_marks');
                                foreach ($usersMark as $Marks) {
                                        $totalMark = $totalMark+$Marks;
                                }
                                @endphp
                                <tr>
                                    <td>{{ $manager->id }}</td>
                                    <td><a href="/users/{{ $manager->id }}"> {{ $manager->name }} </a></td>
                                    <td><a href="/email/{{ $manager->id }}"> {{ $manager->email }}</a></td>
                                    <td>{{ $manager->created_at }}</td>
                                    <td>{{ $manager->type }}</td>
                                    <td>{{ $manager->status }}</td>
                                    <td class="text-center"><a href="/records/{{ $manager->id }}">{{ $totalMark }}</a></td> 
                                </tr>
                            @endforeach 
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


@endif

@endsection