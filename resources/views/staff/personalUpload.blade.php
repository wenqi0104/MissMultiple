@extends('layouts.app2')
@section('content')


@php
    use App\Material;
    use App\New_Exercise;
    use App\Paper;
    use App\Exam;
    use App\Answer;


    $papers = Paper::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(8);
    $paper = Paper::where('user_id',auth()->user()->id)->count();
    
    $exams = Exam::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(8);
    $exam = Exam::where('user_id',auth()->user()->id)->count();
    
    $materials = Material::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(8);
    $material = Material::where('user_id',auth()->user()->id)->count();
    
    $new_exercises = New_Exercise::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(10);
    $new_exercise = New_Exercise::where('user_id',auth()->user()->id)->count();

    

@endphp



<div class="contatiner">
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
                   <a href="/papers"><button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Go to exercise books page">
                      <i class="material-icons">fact_check</i>Check
                    </button> </a>  
                </div>
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Title</th>
                              <th>Belongs to</th>
                              <th class="text-center">Questions</th>
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
                            <td> {{ $paper->material->title }}</td>
                            <td class="text-center"> {{ $eCount }}</td>
                            <td class="td-actions text-center">
                                  {!! Form::open(['action'=> ['PapersController@destroy',$paper->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                                  {{ Form::hidden('_method','DELETE') }}
                                  <a href="/papers/{{ $paper->id }}/edit" ><button type="button" rel="tooltip" class="btn btn-info btn-round">
                                    <i class="material-icons">edit</i>
                                  </button></a>
                                  <button type="submit" rel="tooltip" class="btn btn-danger btn-round"  onclick="return confirm('Are you sure to delete this exercise book ?')">
                                    <i class="material-icons">close</i>
                                    </button>
                                  {!! Form::close() !!}  
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
        </div>


        <div class="col-md-6 ml-auto mr-auto">
            <div class="card card-chart">
            <div class="card-header card-header-rose" data-header-animation="true">
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">description</i>
                </div>
                <div class="col-6">
                  <h4><b>Quiz</b> Amount :</h4>
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
                   <a href="/exams"><button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Go to quizs page">
                      <i class="material-icons">fact_check</i>Check
                    </button> </a>  
                </div>
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Title</th>
                              <th>Belongs to</th>
                              <th class="td-actions text-center">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($exams as $exam)    
                          <tr>
                            <td><a href="/exams/{{ $exam->id }}">{{ $exam->title }}</a></td>
                            <td> {{ $exam->material->title }}</td>
                            <td class="td-actions text-center">
                                  {!! Form::open(['action'=> ['ExamsController@destroy',$exam->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                                  {{ Form::hidden('_method','DELETE') }}
                                  <a href="/exams/{{ $exam->id }}/edit" ><button type="button" rel="tooltip" class="btn btn-info btn-round">
                                    <i class="material-icons">edit</i>
                                  </button></a>
                                  <button type="submit" rel="tooltip" class="btn btn-danger btn-round"  onclick="return confirm('Are you sure to delete this quiz ?')">
                                    <i class="material-icons">close</i>
                                    </button>
                                  {!! Form::close() !!}  
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
          </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card card-chart">
            <div class="card-header card-header-success" data-header-animation="true">
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">library_books</i>
                </div>
                <div class="col-6">
                  <h4><b>Material</b> Amount :</h4>
                  <br>
                  <h3> {{ $material }}</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="card-actions">
                    <a href="/materials/create"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Create">
                      <i class="material-icons">add</i>Create
                    </button></a>
                   <a href="/materials"><button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Go to materials page">
                      <i class="material-icons">fact_check</i>Check
                    </button> </a>  
                </div>
                    <table class="table">
                      <thead>
                          <tr>
                              <th>Id</th>
                              <th>Title</th>
                              <th>Create Time</th>
                              <th class="text-center">Video</th>
                              <th class="text-center">Image</th>

                              <th class="td-actions text-center">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($materials as $material)    
                          <tr>
                            <td>{{ $material->id }}</td>
                            <td><a href="/materials/{{ $material->id }}">{{ $material->title }}</a></td>
                            <td>{{ $material->created_at }}</td>
                            @if ($material->uploads != 'no video')
                                <td class="text-center"> <a href="/storage/uploads/{{ $material->uploads }}" target="view_window"> {{ $material->uploads }}</a> </td>
                            @else
                                <td class="text-center">No video</td>
                            @endif
                            @if ($material->images != '["noimage.jpg"]')
                                <td class="text-center">Yes</td>
                            @else
                                <td class="text-center">No Image</td>  
                            @endif
                            
                            <td class="td-actions text-center">
                                  {!! Form::open(['action'=> ['MaterialsController@destroy',$material->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                                  {{ Form::hidden('_method','DELETE') }}
                                  <a href="/materials/{{ $material->id }}/edit" ><button type="button" rel="tooltip" class="btn btn-info btn-round">
                                    <i class="material-icons">edit</i>
                                  </button></a>
                                  <button type="submit" rel="tooltip" class="btn btn-danger btn-round"  onclick="return confirm('Are you sure to delete this material ?')">
                                    <i class="material-icons">close</i>
                                    </button>
                                  {!! Form::close() !!}  
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      {{ $materials->links() }}
                    </div>
                  </div>
            </div>
          </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card card-chart">
            <div class="card-header card-header-warning" data-header-animation="true">
              <div class="row">
                <div class="ct-chart col-6 text-center " style="display: flex; flex-direction: column;justify-content:center;height:100px;width: 100px;text-align: center;">
                    <i class="material-icons" style="font-size: 80px;">create</i>
                </div>
                <div class="col-6">
                  <h4><b>Question</b> Amount :</h4>
                  <br>
                  <h3> {{ $new_exercise }}</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="card-actions">
                    <a href="/new_exercises/create"><button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Create">
                      <i class="material-icons">add</i>Create
                    </button></a>
                   <a href="/new_exercises"><button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Go to questions page">
                      <i class="material-icons">fact_check</i>Check
                    </button> </a>  
                </div>
                    <table class="table text-center">
                      <thead>
                          <tr>
                              <th class="text-left">Title</th>
                              <th>Question</th>
                              <th>Mcq</th>
                              <th>Correct Answer</th>
                              <th>Marks</th>
                              <th>Answer records</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($new_exercises as $exercise)    
                          <tr>
                            <td class="text-left"><a href="/new_exercises/{{ $exercise->id }}">{{ $exercise->title }}</a></td>
                            @php
                                $m_mcq = $exercise->mcq;
                                /* //将转义后的双引号更改为空字符
                                $m_mcq = str_replace('",null,null,nul','', $m_mcq); */
                                
                                $c = explode('","',trim($m_mcq));

                                $cCount = count($c);

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

                            {{-- 问题部分 --}}
                            @if ($h == 1)
                                <td>{{ $exercise->multiplier }} &times; {{ $exercise->multiplicand }} = ?</td>
                            @elseif($h == 2)
                                <td>{{ $exercise->multiplier }} &times; ? = {{ $exercise->product }}</td>
                            @else
                                <td>? &times; {{ $exercise->multiplicand }} = {{ $exercise->product }}</td>
                            @endif

                            
                            {{-- mcq部分 --}}
                            @if ($cCount > 2)
                            <td>[ 
                                @foreach ($c as $singleC)
                                  &nbsp;{{ $singleC }}&nbsp;
                                @endforeach
                                ]
                            </td>
                            @else
                            <td>No Mcq</td>
                            @endif
                            <td> {{ $correctAns }} </td>
                            <td> {{ $exercise->marks}}</td>
                            {{-- 学生问题回答记录 --}}
                            @php
                                $answerCounts = Answer::where('exercise_id',$exercise->id)->count();
                            @endphp
                            <td><a href="/answerRecords/{{ $exercise->id }}">{{ $answerCounts }}</a></td>
                            
                            <td class="td-actions">
                                  {!! Form::open(['action'=> ['NewExercisesController@destroy',$exercise->id],'method'=>'POST','style'=>'display:inline-block' ]) !!}
                                  {{ Form::hidden('_method','DELETE') }}
                                  <a href="/new_exercises/{{ $exercise->id }}/edit" ><button type="button" rel="tooltip" class="btn btn-info btn-round">
                                    <i class="material-icons">edit</i>
                                  </button></a>
                                  <button type="submit" rel="tooltip" class="btn btn-danger btn-round" onclick="return confirm('Are you sure to delete this question ?')">
                                    <i class="material-icons">close</i>
                                    </button>
                                  {!! Form::close() !!}  
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      {{ $new_exercises->links() }}
                    </div>
                  </div>
            </div>
          </div>
        </div>
    </div>
    
</div>


@endsection