<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon页面小标签-->
    <link rel="icon" type="image/x-icon" href="/../storage/helper/logo.ico" />


    <title>{{ config('app.name', 'Miss Multiple') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script> --}}
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- about page --}}
    



    {{-- 模板文件 --}}
        <!-- CSS Files -->   
<link href="{{ asset('assets/css/material-dashboard.min.css') }}" rel="stylesheet" />
<!--   Core JS Files   -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('assets/js/core/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/arrive.min.js') }}"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Chartist JS -->
<script src="{{ asset('assets/js/plugins/chartist.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets/js/material-dashboard.js') }}" type="text/javascript"></script>
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/style.css">

<style>
    
body{
    margin: 0;
    font-family: Nunito,sans-serif;
    font-size: .9rem;
    font-weight: 400;
    line-height: 1.6;
    color: #212529;
    text-align: left;
    background-color: #f8fafc;
}




#sidebarme .material-icons{
    position: relative; 
    right: 9px;
    top: -1px !important;
}
    
#navbarNav li a{
    color: white;
}    

#navbarNav li:hover{
    background-color: #F39C12 ;
    box-shadow: 2px 5px 8px gray;
    border-radius: 5em;
    padding: 2px 8px;
}

.navbar-nav .btn4{
    background-color:#F39C12 ;
    color: white;
    border-radius: 5em;
    padding: 2px 8px;

}



</style>

</head>
<body>
    
    
    <div class="container-fluid" style="overflow-x: hidden">

        <div class="row" id="app">
        {{-- 侧边框 --}}
            <div id="sidebarme"  class="col-3 px-1 bg-white position-fixed sidebarme" >
                @include('inc.sidebar')
            </div>
        
        {{-- 内容 --}}
            <div class="col-9 offset-3" id="main">
                {{-- 顶部导航栏 --}}
                <div id="navbarme">
                    @include('inc.nevbar2')
                </div>
                
                {{-- 发送反馈 --}}
                @include('inc.message')
                {{-- 内容 --}}
                @yield('content')
            </div>
        </div>

    </div>





 

</body>
</html>
