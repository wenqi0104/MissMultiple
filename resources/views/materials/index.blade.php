<style>
body{
    background-color: #eee;
    margin-top:20px;
    text-decoration: none;
}

a{
    text-decoration: none !important;
    color: orange;
}

button{
    color:orange !important;
}

.media.media-news {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    position: relative;
    padding-bottom: 210px;
}
@media (min-width: 768px) {
    .media.media-news {
        padding-bottom: 0;
        margin-bottom: 0;
    }
}
@media (min-width: 1200px) {
    .media.media-news {
        padding-bottom: 25px;
        margin: 5vh 0;
    }
}
.media.media-news .media-body {
    padding: 20px;
    box-shadow: 0 22px 28px 0 rgba(0, 0, 0, 0.06);
    background: #fff;
    position: absolute;
    width: 90%;
    right: 0;
    bottom: 0;
}


@media (min-width: 768px) {
    .media.media-news .media-body {
        position: relative;
        padding: 46.5px 35px;
        right: 0;
    }
}
@media (min-width: 992px) {
    .media.media-news .media-body {
        right: 40px;
        bottom: 0;
    }
}
@media (min-width: 1200px) {
    .media.media-news .media-body {
        position: absolute;
        right: 35px;
        width: 68%;
        padding: 20px;
    }
}

.media-img:{
    animation-direction: alternate;
    
}

.media-img:hover{
    animation: fronte 0.8s linear forwards; 
    position: relative;
    z-index: 4;
}
@keyframes fronte{
    from { z-index: 0; transform: scale(1); opacity: 0.9; }
    to { z-index: 4; transform: scale(1.2); opacity: 1; }
}



.media.media-news .media-body .media-date {
    font-family: "Open Sans", sans-serif;
    color: #848484;
    margin-bottom: 10px;
}
.media.media-news .media-body h5 {
    font-size: 22px;
    padding-bottom: 15px;
    margin-bottom: 20px;
}
.media.media-news .media-body h5.small {
    font-size: 16px;
}
.media.media-news .media-body p {
    font-family: "Open Sans", sans-serif;
    color: #848484;
}
.media.media-news .media-body .common-btn {
    margin-top: 10px;
}


.materialsme{
    position: relative;
    
}

#edit{
    float: right;
    font-size: 20px;
    color: aquamarine;
}




.point {
    width: 80px;
    height: 80px;
    background-image: linear-gradient(to top, #9be15d 0%, #00e3ae 100%);
    position: absolute;
    top: -70px;
    right: 50px;
    z-index: 10;
    text-align: center;
    border-radius: 50%;
    line-height: 80px;
    font-size: 18px;
  }
 
  /* 设置动画前颜色 */
  .point-flicker:after {
    background-color: #9be15d;
  }
 
  /* 设置动画后颜色 */
  .point-flicker:before {
    background-color:#00e3ae;
  }
 
  /* 设置动画 */
  .point-flicker:before,
  .point-flicker:after {
    content: '';
    width: 100px;
    height: 100px;
    position: absolute;
    z-index: -1;
    left: 0;
    top: 0;
    margin-left: -10px;
    margin-top: -10px;
    border-radius: 50%;
    animation: warn 1.5s ease-out 0s infinite;
  }
 
  /* @keyframes 规则用于创建动画。在 @keyframes 中规定某项 CSS 样式，就能创建由当前样式逐渐改为新样式的动画效果。 */
  @keyframes warn {
    0% {
      transform: scale(0.5);
      opacity: 1;
    }
 
    30% {
      opacity: 1;
    }
 
    100% {
      transform: scale(1.4);
      opacity: 0;
    }
  }

</style>


@extends('layouts.app')
@section('content')

@php
    use App\ActivityMark;
    use Carbon\Carbon;

@endphp




<div class="container materialsme">
    <div class="point point-flicker">
        <a class="link text-light" href="/../storage/helper/MissMultiple.pdf" title="Video content Assist">Helper</a>
    </div>


    @if (count($materials)>0)
        
        <div class="row no-gutters">
        @foreach ($materials as $material)
        @php
        if (Auth::check()) {
            $numOfVisits = ActivityMark::where('user_id','=',auth()->user()->id)->where('material_id', '=', $material->id)->count();

                //从记录中找到创建日期并变为时间戳
                if ($numOfVisits>0) {
                    $records = ActivityMark::where('user_id','=',auth()->user()->id)->where('material_id', '=', $material->id)->latest('created_at')->first();
                    $create = Carbon::parse($records->created_at)->timestamp;

                    $timenow = Carbon::now();
                    $time = Carbon::parse($timenow)->timestamp;

                    $result = $time-$create;
                }else{
                    $result = 86401;
                }
            }

            $imageName = substr($material->images,2,-2);
            //将转义后的双引号更改为空字符
            $imageName = strtr($imageName,"\"", " ");
            //将剩下的内容分隔为当数值然后存入数组中  explod（）方法直接就会变为数组
            $imageName = explode(' , ',trim($imageName));
        @endphp

            <div class="col-6">
                <div class="media media-news">
                    @if (count($imageName) >= 1)
                        <div class="media-img" style="width: 350px; height: 280px">
                            <img src="/../storage/img/{{ $imageName[0] }}" alt="material image" style="width:100%; height:100%;object-fit:cover; border-radius:20px; ">
                        </div>
                    @endif
                    <div class="media-body shadow-lg" style="border-radius: 15px;">
                        <div>
                            <img src = "/storage/img/{{ $material->user->avatar }}" alt="avatar.png"  style="width:50px; height:60px; object-fit:cover; border-radius:20px"> 
                            <span class="text-right">{{ $material->user->name }}</span>
                            {{-- edit标签 --}}
                            @if (!Auth::guest())
                                @if (Auth::user()->id == $material->user_id || Auth::user()->type == "Admin")
                                    <a class="edit" href="/materials/{{ $material->id }}/edit" id="edit">edit</a>
                                @endif
                            @endif
                            <p class="media-date"><i class="material-icons">update</i><b>{{ $material->created_at->diffForHumans() }}</b> --- <span> {{ Carbon::parse($material['created_at'])->format('d M Y') }}</span></p>
                            <br>     
                        </div>
                        <h5 class="mt-0 sep">{{ $material->title }}</h5>
                        <p> {{ $material->description }}</p>


                        
                        {{-- 如果数据库里的加分记录数是0，就可以加一次分 --}}
                    @if(Auth::check() && $result > 86400)
                        {!! Form::open(['action'=> 'ActivityMarksController@store','method'=>'POST']) !!}    
                        {{ csrf_field() }}
                        <input type="hidden" value="10"  name="activity_marks">
                        <input type="hidden" value="{{ $material->id }}" name="material_id">
                        <button class="btn" type="submit">View More</button>
                        {!! Form::close() !!}
                    @else
                        <button class="btn"><a href="/materials/{{ $material->id }}">View More</a></button>  
                    @endif

                    </div>
                </div>
            </div>
        
        @endforeach
        <div class="col-12 d-flex justify-content-center " style="margin-top:5vh;">
            {{ $materials->links() }}
        </div>
        </div>
    @endif



    {{-- 上传新课件按钮 --}}
    @if (!Auth::guest())
        @if(Auth::user()->type !== 'Student')
            <div class="btnme">
                <p><a href="/materials/create"> <span class="material-icons">control_point</span></a></p>
                <a class="upload" href="/materials/create">Upload</a>
            </div>
        @endif
    @endif
</div>
    
        
    
@endsection
