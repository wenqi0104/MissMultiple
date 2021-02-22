@extends('layouts.app2')
@section('content')

@php
    use App\Answer;
    
    $records = Answer::where('exercise_id',$exercise->id)->orderBy('created_at','desc')->paginate(20);
    $recordCount = Answer::where('exercise_id',$exercise->id)->count();

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


@if (Auth::check()) 
       <div class="card card-chart">
            <div class="card-header card-header-danger ">
                <div class="row">
                  <div class="col-3 offset-1">
                    <h4>Question:</h4>
                    {{-- 问题部分 --}}
                    @if ($h == 1)
                        <h3>{{ $exercise->multiplier }} &times; {{ $exercise->multiplicand }} = ?</h3>
                    @elseif($h == 2)
                        <h3>{{ $exercise->multiplier }} &times; ? = {{ $exercise->product }}</h3>
                    @else
                        <h3>? &times; {{ $exercise->multiplicand }} = {{ $exercise->product }}</h3>
                    @endif
                  </div>
                  <div class="col-4">
                    <h4>Correct Answer :</h4>
                    <h3 style="color: lightgreen">{{ $correctAns }}</h3>
                  </div>
                  <div class="col-4">
                      <div style="display: inline-block">
                          <h4>Answer Records :</h4>
                          <h3 style="color: yellow">{{ $recordCount }}</h3>
                      </div>
                      
                      <div style="display:inline-block; float: right">
                          @if (auth()->user()->type == 'Admin')
                          <a href="/admin/personalUpload"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Go Back">
                          <i class="material-icons" style="color: white;">first_page</i>  <span style="color: white">Go Back</span>
                          </button></a>
                          @elseif (auth()->user()->type == 'Staff')
                          <a href="/staff/personalUpload"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Go Back">
                          <i class="material-icons" style="color: white;">first_page</i>  <span style="color: white">Go Back</span>
                          </button></a>
                          @endif
                      </div>
                  </div>
                </div>
            </div>
            <div class="card-body text-center">
                @if ($recordCount >0)
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Answer By</th>
                              <th>Answer</th>
                              <th>Time</th>
                              <th>Result</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($records as $record) 
                        
                          <tr>
                            <td> {{ $record->user->name }}</td>
                            <td> {{ $record->answers }}</td>
                            <td> {{ $record->created_at }}</td>
                            @if ($record->answers == $correctAns)
                              <td>
                                <span class="material-icons text-success">
                                  check
                                </span>
                              </td>
                            @else
                              <td>
                                <span class="material-icons text-danger">
                                  clear
                                </span>
                              </td>
                            @endif
                            <td>
                              {!! Form::open(['action'=> ['AnswersController@destroy',$record->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                              {{ Form::hidden('_method','DELETE') }}
                              <button type="submit" rel="tooltip" class="btn btn-danger btn-round">Delete</button>
                              {!! Form::close() !!}  
                            </td>


                            @if ($record->description != null)
                              <td>{{ $record->description }}</td>
                            @endif
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
                    <h3>No one answer this question yet</h3>
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