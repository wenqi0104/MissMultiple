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

  $users = User::all()->count();
  $materials = Material::all()->count();
  $questions = New_Exercise::all()->count();

  $exams = Exam::orderBy('created_at','desc')->paginate(8);
  $exam = Exam::all()->count();
  
  $papers = Paper::orderBy('created_at','desc')->paginate(8);;
  $paper = Paper::all()->count();

  $timenow = Carbon::now();
  $time = Carbon::parse($timenow)->format('d M Y');

  $lastMaterial = Material::latest('created_at')->first();
  $MaterialDate = Carbon::parse($lastMaterial['created_at'])->format('d M Y');

  $lastExam = Exam::latest('updated_at')->first();
  $examDate = Carbon::parse($lastExam['updated_at'])->format('d M Y');
  
  $lastPaper = Paper::latest('updated_at')->first();
  $paperDate = Carbon::parse($lastPaper['updated_at'])->format('d M Y');

  $answers = Answer::where('exercise_id',0)->orderBy('exam_id','asc')->paginate(8);
  $answersCount = $answers->count();
 
  $students = User::where('type','Student')->paginate(15);
 
@endphp



<div class="conatiner">

<div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon" > 
                  <div class="card-icon" >
                    <i class="material-icons">library_books</i>
                  </div>
               
                  <p class="card-category">Learning resource</p>
                  <h3 class="card-title">{{ $materials }}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  <i class="material-icons">date_range</i> Last upload: &nbsp; <b> {{ $MaterialDate }}</b>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">create</i>
                </div>
                  <p class="card-category">Questions</p>
                  <h3 class="card-title"> {{ $questions }}
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i>Until now: &nbsp;<b>{{ $time }}</b> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <p class="card-category">Exercise Book</p>
                <h3 class="card-title"> {{ $paper }}</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">event</i>Last update: &nbsp;<b>{{ $paperDate }}</b> 
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
                  <p class="card-category">System Users</p>
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
      <div class="col-md-6 ml-auto mr-auto">

          <div class="card card-chart">
            <div class="card-header card-header-danger " data-header-animation="true">
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">assignment</i>
                </div>
                <div class="col-6">
                  <h4><b>Exercise Book</b> Amount :</h4>
                  <br>
                  <h3> {{ $paper }}</h3>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-actions">
                    <a href="/papers/create"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Create">
                      <i class="material-icons">add</i>Create
                    </button></a>
                   <a href="/papers"><button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Go to exercise book page">
                      <i class="material-icons">fact_check</i>Check
                    </button> </a>  
                </div>
                <h4 class="card-title">Current Exercise Book:</h4>
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Title</th>
                              <th>Create User</th>
                              <th>Belongs to</th>
                              <th class="text-center">Questions Count</th>
                              <th class="td-actions text-center">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($papers as $paper) 
                           @php
                            $ex_id = $paper->new_exercise_id;
                            $eid = explode('","',trim($ex_id));
                            $eCount = count($eid);
                        @endphp
                          <tr>
                            <td><a href="/papers/{{ $paper->id }}">{{ $paper->title }}</a></td>
                            <td> {{ $paper->user->name }}</td>
                            <td> {{ $paper->material->title }}</td>
                            <td class="text-center"> {{ $eCount }}</td>
                            <td class="td-actions text-center">
                                @if (auth()->user()->id == $paper->user_id)
                                  {!! Form::open(['action'=> ['PapersController@destroy',$paper->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                                  {{ Form::hidden('_method','DELETE') }}
                                    <a href="/papers/{{ $paper->id }}/edit">
                                      <button type="button" rel="tooltip" class="btn btn-info btn-round"><i class="material-icons">edit</i></button>
                                    </a>
                                    <button type="submit" rel="tooltip" class="btn btn-danger btn-round" onclick="return confirm('Are you sure to delete this exercise book ?')">
                                    <i class="material-icons">close</i>
                                  </button>
                                  {!! Form::close() !!}
                                  @else
                                  <span>No available</span>
                                @endif                        
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      {{ $papers->links() }}
                    </div>
                  </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                  <i class="material-icons">access_time</i>Just Updated
              </div>
            </div>
          </div>


          <div class="card card-chart">
            <div class="card-header card-header-rose" data-header-animation="true">
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">description</i>
                </div>
                <div class="col-6">
                  <h4>Current <b>Quiz</b> Amount :</h4>
                  <br>
                  <h3> {{ $exam }}</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="card-actions">
                    <a href="/exams/create"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Create">
                      <i class="material-icons">add</i>Create
                    </button></a>
                   <a href="/exams"><button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Go to quiz page">
                      <i class="material-icons">fact_check</i>Check
                    </button> </a>  
                </div>
                <h4 class="card-title">Current Quiz :</h4>
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Title</th>
                              <th>Create User</th>
                              <th>Belongs to</th>
                              <th class="td-actions text-center">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($exams as $exam)    
                          <tr>
                            <td><a href="/exams/{{ $exam->id }}">{{ $exam->title }}</a></td>
                            <td> {{ $exam->user->name }}</td>
                            <td> {{ $exam->material->title }}</td>
                            <td class="td-actions text-center">
                               @if (auth()->user()->id == $exam->user_id)
                                  {!! Form::open(['action'=> ['ExamsController@destroy',$exam->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                                  {{ Form::hidden('_method','DELETE') }}
                                  <a href="/exams/{{ $exam->id }}/edit" ><button type="button" rel="tooltip" class="btn btn-info btn-round">
                                    <i class="material-icons">edit</i>
                                  </button></a>
                                  <button type="submit" rel="tooltip" class="btn btn-danger btn-round"onclick="return confirm('Are you sure to delete this quiz ?')">
                                    <i class="material-icons">close</i>
                                    </button>
                                  {!! Form::close() !!}  
                                @else
                                <span>No available</span>
                                @endif
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      {{ $exams->links() }}
                    </div>
                  </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                  <i class="material-icons">access_time</i>Just Updated
              </div>
            </div>
          </div>

          
      </div>


      <div class="col-md-6 ml-auto mr-auto ">
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
                        <td><a href="users/{{ $uid }}">{{ $username }}</a></td>
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

              <div class="card card-chart">
            <div class="card-header card-header-info" >
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">border_color</i>
                </div>
                <div class="col-6">
                  <h4>Student <b>Quiz Answer</b> Amount :</h4>
                  <br>
                  <h3> {{ $answersCount }}</h3>
                </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <div class="card-actions">
                    <a href="/exams/create"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                      <i class="material-icons">add</i>Create
                    </button></a>
                   <a href="/exams"><button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Go to ">
                      <i class="material-icons">fact_check</i>Check
                    </button> </a>  
                </div> --}}
                <h4 class="card-title">Student Quiz Answer :</h4>
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Student</th>
                              <th>answers file<b class="text-success">(Click to download)</b></th>
                              <th>Belongs to</th>
                              <th class="td-actions text-center">Give Mark</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($answers as $answer)    
                          <tr>
                            <td>{{ $answer->user->name }}</td>
                            <td><a href="/storage/answers_file/{!! $answer->answers_file !!}" download>{{ $answer->answers_file }}</a></td>
                            <td> {{ $answer->exam->title }}</td>
                            <td class="td-actions text-center">
                              @php
                                //将回答记录中当前的uer_id与填表时的exercise_id数据存入$records中
                                $records2 = ActivityMark::where('user_id', '=', $answer->user->id)
                                ->where('exam_id', '=', $exam->id)->get();
                                //用count()计数
                                $recordCount2 = $records2->count();
                              @endphp

                              @if ($recordCount2 < 1 )
                                  <a href="/exams/{{ $answer->exam_id }}" ><button type="button" rel="tooltip" class="btn btn-info btn-round" title="Go to this quiz page to assign marks">
                                    <i class="material-icons">star</i>
                                  </button></a>
                              @else
                                  <span class="text-success">Mark Assigned</span>
                              @endif                                
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      {{ $answers->links() }}
                    </div>
                  </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                  <i class="material-icons">access_time</i>Just Updated
              </div>
            </div>
          </div>


      </div>


</div>



    
  



@endsection