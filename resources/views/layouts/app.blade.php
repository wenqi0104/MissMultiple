<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Miss Multiple') }}</title>

    <!-- Favicon页面小标签-->
    <link rel="icon" type="image/x-icon" href="/../storage/helper/logo.ico" />
   
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    
    {{-- 背景图js --}}
    <script src="{{ asset('assets/TweenMax.min.js') }}" type="text/javascript"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- about page --}}
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/style.css">


    <style>
        
/* #wrapper {
  position:relative;
  background-color: rgb(99,208,255);
  width:100%;
  height:100%;
}
 */

#clouds{
  background:url("/../storage/img/portfolio/background/cloud.png") repeat-x 0 bottom #ACE6FF;
  width:100%;
  min-height:35vh;
  position:absolute;
  top:0;
  left:0;
  z-index:1;
  -webkit-transform:translate3d(0,0,0.01);
  transform:translate3d(0,0,0.01);
}

#ground {
  background:url("/../storage/img/portfolio/background/grass.png") repeat-x 0 0 transparent;    
  position: absolute;
  bottom: 0;
  left: 0;
  z-index:2;
  width: 100%;
  min-height:130px;
  border:0 none transparent;
  outline:0 none transparent;
  -webkit-transform:translate3d(0,0,0.01);
  transform:translate3d(0,0,0.01);
  will-change: transform;
}
    </style>



</head>
<body>
    
    
    <div class="container-fluid" style="overflow-x: hidden">

        <div class="row" id="app">
        {{-- 侧边框 --}}
            <div class="col-3 shadow px-1 bg-white position-fixed sidebarme" >
                @include('inc.sidebar')
            </div>
        
        {{-- 内容 --}}
            <div class="col-9 offset-3" id="main">
                {{-- 顶部导航栏 --}}
                <div id="navbarme">
                    @include('inc.nevbar')
                </div>
                <div style="position: relative; z-index:3;">
                {{-- 发送反馈 --}}
                @include('inc.message')
                </div>
                    {{-- 内容 --}}
                    <div style="position: relative; z-index:3;  padding:14vh 0;">
                        @yield('content')
                    </div>
                    <div id="clouds"></div>
                    <div id="ground"></div>
                
            </div>
        </div>

    </div>





{{-- 图片预览js input的id是这个getelementById的id  div里的id是image_preview --}}
<script type="text/javascript">
    function image_preview(){
        var total_file=document.getElementById("Image").files.length;
            for(var i=0;i<total_file;i++){
                $('#image_preview').append("<img id='previmg' class='img-radius' style='width:100%;' src='"+URL.createObjectURL(event.target.files[i])+"'>");
            }
    }
</script>

{{-- script for editor --}}
    {{-- <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
  --}}
  
<script type="text/javascript">

    $(document).ready(function() {

      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });


      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });
      
    });

   
</script>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {

  function ground() {

    var tl = new TimelineMax({
      repeat: -1
    });

    tl.to("#ground", 20, {
        backgroundPosition: "1301px 0px",
        force3D:true,
        rotation:0.01,
        z:0.01,
        autoRound:false,
        ease: Linear.easeNone
      });

    return tl;
  }

  function clouds() {

    var tl = new TimelineMax({
      repeat: -1
    });

    tl.to("#clouds", 52, {
      backgroundPosition: "-2247px bottom",
      force3D:true,
      rotation:0.01,
      z:0.01,
      //autoRound:false,
      ease: Linear.easeNone
    });
    
    return tl;
  }

  var masterTL = new TimelineMax({
    repeat: -1
  });
  
  // window load event makes sure image is 
// loaded before running animation
window.onload = function() {
  
  masterTL
  .add(ground(),0)
  .add(clouds(),0)
  .timeScale(0.7)
  .progress(1).progress(0)
  .play();

};
  
});
</script>


</body>
</html>
