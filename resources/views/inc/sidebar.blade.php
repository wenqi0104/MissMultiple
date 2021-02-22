@php
    use Illuminate\Support\Facades\Auth;
    use App\ActivityMark;
    use Carbon\Carbon;  
 
    if (Auth::check()) {
        $id = Auth::user()->id;
    }
       
        
@endphp

        {{-- logo 和名字 --}}
        <div class="logo text-center">
                <div style="display:inline-block; width: 95px; vertical-align: top; padding-top:4px">
                        <img src="/../storage/img/portfolio/background/teacher2.png" alt="teacherlogo" style="width: 100%">
                </div>
                <div style="display: inline-block">
                        <a class="nav-link" href="{{ url('/materials') }}">
                                <h1 >Miss</h1>
                                <h4 >Multiple</h4>
                        </a>
                </div>
        </div>

        <div class="nav flex-column flex-nowrap overflow-auto text-white p-2" id="sidebarSupportedContent" >

                @if (Auth::check())
                        @if(auth()->user()->type=='Admin')
                                <a href="/admin" class="nav-link btn1 {!! Request::path() == "admin" ? "btn2" : "btn1" !!}"><span class="material-icons">dashboard</span>Dashboard</a>
                        @elseif(auth()->user()->type == 'Staff')  
                                <a href="/staff" class="nav-link btn1 {!! Request::path() == "staff" ? "btn2" : "btn1" !!}"><span class="material-icons">dashboard</span>Dashboard</a> 
                        @else
                                <a href="/student" class="nav-link btn1 {!! Request::path() == "student" ? "btn2" : "btn1" !!}"><span class="material-icons">dashboard</span>Dashboard</a> 
                        @endif
                @endif
                

                <a href="/materials" class="nav-link btn1 {!! Request::path() == "materials" ? "btn2" : "btn1" !!}"><span class="material-icons">local_library</span>Course Materials</a>
                {{-- 旧的练习系统 
                <a href="/exercises" class="nav-link btn1 {!! Request::path() == "exercises" ? "btn2" : "btn1" !!}"><span class="material-icons">create</span>Exercises</a> --}}
                @if (Auth::check() && auth()->user()->type !=='Student')
                        <a href="/new_exercises" class="nav-link btn1 {!! Request::path() == "new_exercises" ? "btn2" : "btn1" !!}"><span class="material-icons">create</span>Questions</a>
                @endif
                <a href="/papers" class="nav-link btn1 {!! Request::path() == "papers" ? "btn2" : "btn1" !!}"><span class="material-icons">history_edu</span>Exercise Books</a>
                <a href="/exams" class="nav-link btn1 {!! Request::path() == "exams" ? "btn2" : "btn1" !!}"><span class="material-icons">assignment</span>Funny Quizs</a>
                {{-- <a href="/users" class="nav-link btn1 {!! Request::path() == "users" ? "btn2" : "btn1" !!} "><span class="material-icons">folder_shared</span>User Management</a> --}}
                <hr />
                <a href="/" class="nav-link btn1 {!! Request::path() == "/" ? "btn2" : "btn1" !!}"><span class="material-icons">alternate_email</span>About Us</a>
                
                @if (Auth::check())
                <a href="/users/{{ Auth::user()->id }}" class="nav-link btn1 {!! Request::path() == "users/$id" ? "btn2" : "btn1" !!}"><span class="material-icons">perm_identity</span>Profile</a>
                <div>
                        {{-- <a href="{{ route('logout') }}" class="nav-link btn1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> --}}
                        <a href="{{ route('logout') }}" class="nav-link btn1" onclick="event.preventDefault(); logOut()">
                          <span class="material-icons">exit_to_app</span>
                          {{ __('Logout') }} 
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>
                </div>
                @endif
        </div>


     <script>
             function logOut(){
                var r = confirm("Are you sure to log out ?");
                if (r == true) {
                document.getElementById('logout-form').submit();
                } 
             }
            
     </script>