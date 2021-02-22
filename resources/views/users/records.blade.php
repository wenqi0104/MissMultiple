@extends('layouts.app2')
@section('content')

@php
    use App\ActivityMark;
    use Carbon\Carbon;

    $records = ActivityMark::where('user_id',$user->id)->orderBy('created_at','desc')->paginate(20);
    $recordCount = ActivityMark::where('user_id',$user->id)->count();
    $totalMark = 0 ;
    //计算活动分数
    $usersMark = ActivityMark::where('user_id',$user->id)->pluck('activity_marks');
    foreach ($usersMark as $Marks) {
        $totalMark = $totalMark + $Marks;
    }

@endphp


@if (Auth::check()) 
       <div class="card card-chart">
            <div class="card-header card-header-danger ">
                <div class="row">
                    <div class="ct-chart col-2 offset-2 text-center " >
                        <img src = "/storage/img/{{ $user->avatar }}" alt="studentavatar.png"  style="width: 100%;">
                    </div>
                    <div class="col-8">
                        <div style="display: inline-block">
                            <h4> User:</h4>
                            <h3> <b style="color: green">{{ $user->name }}</b> </h3> 
                            <br>
                            <h4> Total Mark : </h4>
                            <h3 style="color: yellow">{{ $totalMark }}</h3>
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
                            <i class="material-icons" style="color: white;">first_page</i> <span style="color: white">Go Back</span>
                            </button></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($recordCount >0)
                    <table class="table">
                      <thead>
                          <tr>
                              <th class="text-center">Activity Marks</th>
                              <th class="text-center">Time</th>
                              <th class="text-center">Type</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($records as $record) 
                        
                          <tr>
                            <td class="text-center">+{{ $record->activity_marks }}</td>
                            <td class="text-center"> {{ Carbon::parse($record->created_at)->format('d-m Y') }}</td>
                            <td class="text-center"> {{ $record->type }}</td>
                          </tr>
                          @endforeach

                      </tbody>
                  </table>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      {{ $records->links() }}
                    </div>
                  </div>
                @else
                    <h3> This user is lazy.....</h3>
                @endif


                
            </div>
            <div class="card-footer">
              <div class="stats">
                  <i class="material-icons">access_time</i>Just Updated
              </div>
            </div>
          </div>

    


@endif

@endsection