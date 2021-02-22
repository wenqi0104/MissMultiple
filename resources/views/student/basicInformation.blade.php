@extends('layouts.app2')
@section('content')
@php

    use App\User;
    use App\Material;
    use App\Paper;
    use App\New_Exercise;
    use App\Exam;
    use App\Answer;
    use App\ActivityMark;
    use Carbon\Carbon;

  $users = User::where('type','Student')->count();
  $materials = Material::all()->count();
  $questions = New_Exercise::all()->count();



  $timenow = Carbon::now();
  $time = Carbon::parse($timenow)->format('d M Y');

  $answers = Answer::where('user_id',auth()->user()->id)->where('exam_id',null)->orderBy('created_at','desc')->paginate(8);
  $answersCount = $answers->count();

  $students = User::where('type','Student')->get();
  $lastActive = ActivityMark::where('user_id',auth()->user()->id)->latest('created_at')->first();
  $ActiveDate = Carbon::parse($lastActive['created_at'])->format('d M Y');

  $records = ActivityMark::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(8);
  $recordCount = ActivityMark::where('user_id',auth()->user()->id)->count();
  $totalMark = 0 ;

          
  $StudentMark = 0 ;
  //计算活动分数
  $Marks = ActivityMark::where('user_id',auth()->user()->id)->pluck('activity_marks');
  foreach ($Marks as $Mark) {
    $StudentMark = $StudentMark + $Mark;
  }
  
                       
                      
@endphp



<div class="conatiner">

<div class="row">

            <div class="col-lg-6 col-md-12 col-sm-12">
              <div class="card card-stats">
                <div class="card-header card-header-success row ">
                  
                  <div class="ct-chart col-4  text-center " >
                    <img src = "/storage/img/{{ auth()->user()->avatar }}" alt="studentavatar.png"  style="width: 100%;">
                  </div>

                  <div class="col-4">
                        <h4 class="card-title">Welcome</h4>
                        <br><br>
                        <p class="category"> {{ Auth::user()->name }}</p>
                  </div>
                  <div class="col-4" style="position: relative; right:12px;">
                    <a href="/users/{{ auth()->user()->id }}/edit"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="profile edit">
                      <i class="material-icons" style="color: white;">edit</i> <span style="color: white">Edit profile</span>
                    </button></a>
                  </div>

                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> You are with us since : &nbsp; <b> {{ Carbon::parse(auth()->user()->created_at)->format('d M Y') }}</b>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">polymer</i>
                </div>
                  <p class="card-category">Your Activity Mark:</p>
                  <h3 class="card-title"> {{ $StudentMark }}
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last update: &nbsp; <b> {{ $ActiveDate }}</b>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">group</i>
                  </div>
                  <p class="card-category">Frinds</p>
                <h3 class="card-title"> {{ $users }}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Just Updated
                  </div>
                </div>
              </div>
            </div>
</div>



<div class="row">
      
      <div class="col-md-4 ml-auto mr-auto ">
          <div class="card">
                <div class="card-header card-header-warning">
                  <div style="display: inline-block">
                  <h4 class="card-title">Ranking Board</h4>
                  <p class="card-category">list of top 15</p>
                  </div>
                  <div style="display:inline-block; float: right;">
                  <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh" onClick="document.location.reload()">
                    <i class="material-icons">refresh</i>
                  </button>
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <tr>
                      <th>Top</th>
                      <th>Name</th>
                      <th class="text-center">Activity Marks</th>
                    </tr>
                  </thead>
                    <tbody>
                      @php
                          $total = [];
                          $IDs = [];
                      @endphp
                      @foreach ($students as $student)

                        @php
                        $totalMark = 0;
                        //计算活动分数
                        $usersMark = ActivityMark::where('user_id',$student->id)->pluck('activity_marks');
                        foreach ($usersMark as $Marks) {
                          $totalMark = $totalMark + $Marks;
                        }
                        $total[] = $totalMark;
                        $IDs[] = $student->id;
                        @endphp

                      @endforeach

                      @php
                        arsort($total);
                        $count = 1;
                        $c = 0;
                        $indexOrd = array_keys($total);
                      @endphp

                      @foreach ($indexOrd as $ind)

                        @php
                        $uid = $IDs[$ind];
                        $uname = User::where('id', $uid)->first('name');
                        $username = substr($uname, 9,-2);
                        @endphp

                      <tr>
                        <td>{{ $count }}</td>
                        <td><a href="users/{{ $uid }}">{{ $username }}</a>  </td>
                        <td class="text-center"><a href="/records/{{ $uid }}">{{ $total[$ind] }}</a></td>
                      </tr>

                        @php
                            $count++;
                            $c++;
                        @endphp

                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
      </div>

      <div class="col-md-8 ml-auto mr-auto">  
        <div class="card card-chart">
            <div class="card-header card-header-rose">
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">polymer</i>
                </div>
                <div class="col-6">
                  <h4>Your <b>Activity Mark :</b></h4>
                  <br>
                <h3> {{ $StudentMark}}</h3>
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
                    <h3>You haven't got any mark.....Come on</h3>
                @endif
     
            </div>
            <div class="card-footer">
              <div class="stats">
                  <i class="material-icons">access_time</i>Updated at {{ $ActiveDate }}
              </div>
            </div>
          </div>
     
      
      
       
        <div class="card card-chart text-center">
            <div class="card-header card-header-primary">
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">question_answer</i>
                </div>
                <div class="col-6">
                  <h4>Your <b>Answer :</b></h4>
                  <br>
                <h3> {{ $answersCount }}</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                @if ($answersCount >0)
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Question</th>
                              <th>Correct Answer</th>
                              <th>Your Answer</th>
                              <th>Time</th>
                              <th>Result</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($answers as $answer) 
                        @php
                        $exercise = New_Exercise::find($answer->exercise_id);    
                        
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

                          <tr>
                            
                            @if ($h == 1)
                                <td>{{ $exercise->multiplier }} &times; {{ $exercise->multiplicand }} = ?</td>
                            @elseif($h == 2)
                                <td>{{ $exercise->multiplier }} &times; ? = {{ $exercise->product }}</td>
                            @else
                                <td>? &times; {{ $exercise->multiplicand }} = {{ $exercise->product }}</td>
                            @endif
                            <td> {{ $correctAns }}</td>
                            <td> {{ $answer->answers }}</td>
                            <td> {{ Carbon::parse($answer->created_at)->format('d-m Y') }}</td>
                            @if ($answer->answers == $correctAns)
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
                          </tr>
                          @endforeach

                      </tbody>
                  </table>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      {{ $answers->links() }}
                    </div>
                  </div>
                @else
                    <h3>Ohhh,You haven't answer any question...</h3>
                @endif
     
            </div>
            <div class="card-footer">
              <div class="stats">
                  <i class="material-icons">access_time</i>Updated at {{ $ActiveDate }}
              </div>
            </div>
          </div>
      </div>
</div>



    
  



@endsection