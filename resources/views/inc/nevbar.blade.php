@php
    use Illuminate\Support\Facades\Auth;
    use App\ActivityMark;
    use Carbon\Carbon;

 $totalMark = 0;

    if (Auth::check()){
        $id = Auth::user()->id;
            //计算活动分数
            $usersMark = ActivityMark::where('user_id',$id)->pluck('activity_marks');
            foreach ($usersMark as $Marks) {
                $totalMark = $totalMark+$Marks;
            }
            

            // 判断记录数
            $numOfVisits = ActivityMark::where('user_id','=',$id)->where('type', '=', 'Login Mark')->count();

            //从记录中找到创建日期并变为时间戳
            if ($numOfVisits>0) {
                $records = ActivityMark::where('user_id','=',$id)->where('type', '=', "Login Mark")->latest('created_at')->first();
                $create = Carbon::parse($records->created_at)->timestamp;

                $timenow = Carbon::now();
                $time = Carbon::parse($timenow)->timestamp;

                $result = $time-$create;
            }else{
                $result = 86401;
            }

           
        }
@endphp


        <nav class="navbar shadow-sm">
            <div class="container">                
            <!-- Authentication Links -->
            @guest 
            <div class="row ml-auto align-content-end ">
                <a class="nav-link text-light" href="{{ route('login') }}"><span class="material-icons">login</span>
                        {{ __('Login') }}</a>       
                @if (Route::has('register'))
                    <a class="nav-link text-light" href="{{ route('register') }}"><span class="material-icons">how_to_reg</span>
                        {{ __('Register') }}</a>        
                @endif
            </div>
            @else
            {{-- avatar头像部分 --}}
            <div class="ml-auto align-content-end">
                @if (Auth::check() && auth()->user()->type == 'Student')
                    <p id="pStudent">{{ $totalMark }}</p>                        
                @endif




                {{-- 签到按钮 登陆后点击home就可以加入签到分20  一天加一次 --}}
                @if(Auth::check() && $result > 86400)  
                    {!! Form::open(['action'=> 'ActivityMarksController@loginMark','method'=>'POST','style'=>'display:inline-block;']) !!}    
                    {{ csrf_field() }}
                    <input type="hidden" value="20" name="activity_marks">
                    <button class="btn myButton " type="submit">Click me!</button>
                    {!! Form::close() !!}
                
                @endif

                {{-- 身份小胶囊 --}}
                @if (Auth::user()->type == 'Admin')
                    <p class="shadow-sm" id="pAdmin">{{ Auth::user()->type }}</p>  
                @elseif(Auth::user()->type == 'Staff')
                    <p class="shadow-sm"id="pStaff">{{ Auth::user()->type }}</p>  
                @endif
                
                <div style="display:inline-block; width:60px; height:70px; margin-right:2rem;">
                    {{-- <img src = "/storage/img/{{ Auth::user()->avatar }}" alt="avatar.png"  style="width: 100%; height:100%; border-radius: 50px;">  --}}
                    <img src = "/storage/img/{{ Auth::user()->avatar }}" alt="avatar.png"  style="width:100%; height: 100%; object-fit:cover; border-radius: 50px;"> 
                </div>
                {{-- 显示用户名 --}}
                <a href="/users/{{ auth()->user()->id }}" class="name">
                    {{ Auth::user()->name }} 
                </a>
            </div>
            
            @endguest       
            </div>
        </nav>


