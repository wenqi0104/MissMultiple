@extends('layouts.app2')
@section('content')


@if (Auth::check()) 
       <div class="card card-chart">
            <div class="card-header card-header-danger ">
                <div class="row">
                    <div class="ct-chart col-2 offset-2 text-center " >
                        <img src = "/storage/img/{{ $user->avatar }}" alt="studentavatar.png"  style="width: 100%;">
                    </div>
                    <div class="col-8">
                        <div style="display: inline-block">
                            <h4>User:</h4>
                            <h3> <b style="color: green">{{ $user->name }}</b> </h3> 
                            <br>
                            <h4>Write email to this user</h4>
                            
                        </div>
                        
                        <div style="display:inline-block; float: right">
                            @if (auth()->user()->type == 'Admin')
                            <a href="/admin/userManagement"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Go Back">
                            <i class="material-icons" style="color: white;">first_page</i>  <span style="color: white">Go Back</span>
                            </button></a>
                            @elseif (auth()->user()->type == 'Staff')
                            <a href="/staff/userManagement"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Go Back">
                            <i class="material-icons" style="color: white;">first_page</i>  <span style="color: white">Go Back</span>
                            </button></a>
                            @elseif(auth()->user()->type == 'Student')
                            <a href="/student"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Go Back">
                            <i class="material-icons" style="color: white;">first_page</i>  <span style="color: white">Go Back</span>
                            </button></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(['action'=> ['EmailController@sendEmail'],'method'=>'POST']) !!}
                {{ csrf_field() }}
                <input type="hidden" name="user_email" value="{!! $user->email !!}" >
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Message</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="12" name="message" >Dear {{ $user->name }},</textarea>
                    </div>
                {{Form::submit('Send ',['class'=>'btn btn-lg btn-primary'])}}
                {!! Form::close() !!}  
                                   
            </div>
          </div>

    


@endif

@endsection