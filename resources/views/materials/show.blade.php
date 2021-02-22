<style>
    .contatiner{
        position: relative;
    }

        h1,h3{
            color: whitesmoke !important;
        }


    .goBack{
        position: absolute;
        top: 8vh;
        right: 5vh;

    }

    .Iconme{
        width:20vh;
        animation: happy 10s infinite;
    }

    @keyframes happy{
        0%{
            transform:translateX(0);
        }
        50%{
            transform:translateX(100vh);
        }
        100%{
            transform:translateX(0);
        }
    }

    .Iconme img{
        width:100%;
        border-radius: 900px;
    }
</style>

@extends('layouts.app')
@section('content')



<?php
    use App\Comment;
    use App\Exercise;
    use App\Paper;
    

    /* use Illuminate\Support\Facades\Cache; */
    //获取数据库中的文件名然后计入新的参数

    //去除属性中两头的中括号   remove the useless string from both left and right side
   $imageName = substr($material->images,2,-2);
   //将转义后的双引号更改为空字符   replace \ simble with space
   $imageName = strtr($imageName,"\"", " ");
   //将剩下的内容分隔为当数值然后存入数组中  explode（）方法直接就会变为数组    store in a new array
   $imageName = explode(' , ',trim($imageName));
   
   $papers = Paper::where('material_id',$material->id)->get();


 /* Cache::add('view_count','0',5);
    Cache::increment('view_count');
    $counts = Cache::get('view_count'); */

    /* $records = ActivityMark::where('user_id','=',auth()->user()->id)->where('material_id', '=', $material->id)->latest('created_at')->first();
    
    
    $create = Carbon::parse($records->created_at)->timestamp;
    echo $create;
    $timenow = Carbon::now();
    $time = Carbon::parse($timenow)->timestamp;

   */

?>

<div class="container">
    <a href="/materials" class="goBack"><button class="btn btn-primary"><span class="material-icons" style="color: white; line-height:40px">first_page</span></button></a>
    
    <div class="Iconme">
        <img src="../storage/img/portfolio/background/icon2.png" alt="icon2"> 
    </div>
    <div>
        <h1>{{ $material->title }}</h1> 
        @if (Auth::check())
            @if ($material->user_id == auth()->user()->id || auth()->user()->type == 'Admin')
                <span style="float: right"><button class="btn" style="background-image: linear-gradient(to top, #fddb92 0%, #d1fdff 100%); "><a href="/materials/{{ $material->id }}/edit">Edit</a></button> </span>
            @endif
        @endif
        <small>By： {{ $material->user['name'] }}</small>
    </div>
       

        {{-- 循环数据库中的图片 然后输出 --}}
        @if ($material->images != '["noimage.jpg"]') 
            @if (count($imageName) >= 1)
                @foreach ($imageName as $i => $imageName)
                    <div class="d-md-flex flex-md-equal w-100 my-md-6 pl-md-6 justify-content-center">
                        <div class="overflow-hidden" style="border-radius: 21px; margin-bottom:10px; background-color:#fff">
                            <div class="bg-light shadow-sm mx-auto" style="background-position: center; overflow: hidden; border-radius: 21px;">
                                <img src="../storage/img/{{ $imageName }}" alt="material image" style="width:100%; max-width:600px; height:auto; border-radius:21px; padding:8px;">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif


    
        <div style="margin: 3rem">
            <h4 class="text-warning">So this material is about :</h4>
           <h3>{!! $material->description !!}</h3> 
        </div>
    



    @if ($material->uploads !== 'no video')
        <hr>
        <h3>Learning & Thinking</h3>
            {{-- 为了确保各种视频格式的兼容，使用了video，source和embed元素 --}}
            <!-- 视频部分     16:9 aspect ratio -->
            <center>
            <div class="embed-responsive embed-responsive-16by9 text-center" style="width: 700px; ">
                <video controls>
                <source src="/storage/uploads/{{$material->uploads}}" type="video/mp4">
                <object data="/storage/uploads/{{$material->uploads}}" width="320" height="240">
                    <embed src="/storage/uploads/{{$material->uploads}}" width="320" height="240"> 
                </object> 
                </video>
            </div>
            <br><br>
        {{-- 点击链接下载 --}}
            <p><a href="/storage/uploads/{{ $material->uploads }}" download>click to download the video. </a></p>
            </center>
    
       
        

    @endif



        {{-- 以下是edit和删除按钮 --}}

        {{-- @if (!Auth::guest())
        @if(Auth::user()->id == $material->user_id || Auth::user()->type == "Admin")
        <a href="/materials/{{ $material -> id }}/edit" class="btn"> <button class="btn btn-default">Edit</button> </a>
                {!! Form::open(['action'=> ['MaterialsController@destroy',$material -> id],'method'=>'POST', 'class'=>'pull-right' ]) !!}       
                {{ Form::hidden('_method','DELETE') }}
                {{ Form::submit('Delete',['class'=>'btn btn-danger']) }}
                {!! Form::close() !!}  
                @endif
        @endif --}}
                
       

        @if (Auth::check())
            @if (count($papers)>0)
            <hr />
            <a href="#demo" class="btn btn-info" data-toggle="collapse">Wanna some warm up ?  click me</a>
            <div id="demo" class="collapse materialsme row">
                @foreach ($papers as $paper)
                    <div class="col-6" style="margin: 3vh 0 3vh 0;">
                        {{-- 卡片首 --}}
                        <div class="start"  style="background-color:#DDF3FF; border-radius: 15px;  box-shadow:0 0 8px 3px orange;">
                            <h4> <a href="/papers/{{ $paper->id }}">{{ $paper->title }}</a></h4>
                        {{--  ！！！ 这行使用的是model里的user方法 --}}
                            <small>By: {{ $paper->user->name }}</small>
                            {{-- edit按钮 ,只有在用户登录为staff或是admin才能用--}}
                            @if (!Auth::guest())
                                @if(Auth::user()->type !== 'Student')
                                <a class="edit" href="/papers/{{ $paper -> id }}/edit" >edit</a>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
                <hr>
            </div>
            @endif
        @endif
        
@php
    $commentCount = $material->comments->count();
@endphp
<hr>
        <h3>Display Comments</h3>
        @if ($commentCount > 0)
            @foreach($material->comments as $comment)
            <div class="display-comment">
                {{-- 这里使用了model 里定义的user方法 --}}
                 <strong>
                {{ $comment->created_at->diffForHumans() }}:
                </strong>
                <small>{{ $comment->user->name }}</small>
                <p>{{ $comment->body }}</p>
            </div>
        @endforeach
        @else
            <h4 style="color: #fef9d7; margin-top:5vh;">No comments yet, come be the first ！</h4>
        @endif
        
        
<br><br>
    @include('partials._comment_replies', ['comments' => $material->comments, 'material_id' => $material->id])

        <div class="container" style="margin-top: 100px">
            <hr />
        <h3>Add comment</h3>
            {{-- <form method="post" action="{{ route('comment.add') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="comment_body" class="form-control" required/>
                    <input type="hidden" name="material_id" value="{{ $material->id }}" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-warning" value="Add Comment" />
                </div>
            </form> --}}
            <form method="post" action="{{ route('comment.add') }}" class="input-group control-group">
            @csrf
                    <input type="text" name="comment_body" class="form-control" required/>
                    <input type="hidden" name="material_id" value="{{ $material->id }}" />
                    <input type="submit" class="btn btn-warning input-group-btn" value="Add Comment" />
            </form>
 
        </div>
    </div>


    
@endsection