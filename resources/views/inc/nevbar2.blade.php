     @if (Auth::user()->type == 'Admin')
     <nav class="navbar navbar-expand-lg bg-primary">
      <a class="navbar-brand" href="/admin">Admin Dashboard</a>
          <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
          <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav ">  
              <li class="nav-link btn3 {!! Request::path() == "admin" ? "btn4" : "btn3" !!}">
                <a class="nav-link" href="/admin">Basic Information</a>
              </li>
              <li class="nav-link btn3 {!! Request::path() == "admin/personalUpload" ? "btn4" : "btn3" !!}">
                <a class="nav-link" href="/admin/personalUpload">Personal Uploads</a>
              </li>
              <li class="nav-link btn3 {!! Request::path() == "admin/userManagement" ? "btn4" : "btn3" !!}">
                <a class="nav-link" href="/admin/userManagement">User Management</a>
              </li>
              <li class="nav-link btn3 {!! Request::path() == "admin/createUser" ? "btn4" : "btn3" !!}">
                <a class="nav-link disabled" href="/admin/createUser">Create User</a>
              </li>
            </ul>
             <span class="navbar-text ml-auto">
              @if (Request::path() == "admin")
                  <b>Basic Information Page</b>
              @elseif(Request::path() == "admin/personalUpload")
                  <b>Personal Upload Page</b>
              @elseif(Request::path() == "admin/userManagement")
                  <b>User Management Page</b>
              @elseif(Request::path() == "admin/createUser")
                  <b>Create User Page</b>
              @endif
              </span>
          </div>
        </div>
      </nav>

      @elseif(Auth::user()->type == 'Staff')
      <nav class="navbar navbar-expand-lg bg-success">
      <a class="navbar-brand" href="/staff">Staff Dashboard</a>
          <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">  
              <li class="nav-link btn3 {!! Request::path() == "staff" ? "btn4" : "btn3" !!}">
                <a class="nav-link" href="/staff">Basic Information</a>
              </li>
              <li class="nav-link btn3 {!! Request::path() == "staff/personalUpload" ? "btn4" : "btn3" !!}">
                <a class="nav-link" href="/staff/personalUpload">Personal Uploads</a>
              </li>
              <li class="nav-link btn3 {!! Request::path() == "staff/userManagement" ? "btn4" : "btn3" !!}">
                <a class="nav-link" href="/staff/userManagement">User Management</a>
              </li>
            </ul>
            <span class="navbar-text ml-auto">
              @if (Request::path() == "staff")
                  <b>Basic Information Page</b>
              @elseif(Request::path() == "staff/personalUpload")
                  <b>Personal Upload Page</b>
              @elseif(Request::path() == "staff/userManagement")
                  <b>User Management Page</b>
              @endif
              </span>
          </div>
          </div>
      </nav>
      @endif



  