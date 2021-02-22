
<style>
  .aboutme h1{
    font-size: 50px !important;
    
  }

  p{
    font-size: 20px !important;
  }

  .carousel-caption h1,p{
    font-weight: 700;
  }

  .carousel-caption h1{
    text-shadow: 1px 3px 7px rgba(0, 0, 0, 0.2);
  }


  .carousel-caption span{
    background: rgba(0, 0, 0, 0.45);
    color:#FFFF;
    padding: 4px 13px;
  }

  .middleText{
    font-weight: 700;
    color:white;

    
  }
  

</style>

@extends('layouts.app')
@section('content')
     <div class="container" id="aboutme">
      <main role="main">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="/../storage/img/portfolio/background/background1.jpg" style="width: 100%; opacity:0.9;" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left leftme">
                <h1>Miss Multiple</h1>
                <p><span>An online learning platform for multiplication in mathematics.</span></p>
                <a class="btn btn-lg btn-primary" href="/materials" role="button">Get started</a>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="/../storage/img/portfolio/background/background2.jpg" style="width: 100%; opacity:0.9;" alt="Second slide">
            <div class="container">
              <div class="carousel-caption centerme">
                <h1>Our Target</h1>
                <p><span>Developing a web-based online learning system on mathematical Multiplication.</span></p>
                <p><a class="btn btn-lg btn-primary" href="#learnMore" role="button">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="/../storage/img/portfolio/background/background3.jpg" style="width: 100%; opacity:0.9;" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right rightme">
                <h1>Everything is based on user value</h1>
                <p><span>Provide promary students with a way to expand their multiplication learning and practice content.</span></p>
                <p><a class="btn btn-lg btn-primary" href="#gallery" role="button">Browse gallery</a></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing" id="learnMore">

        <!-- Three columns of text below the carousel -->
        <div class="row">
          <div class="col-lg-4">
            <img class="rounded-circle" src="/../storage/img/portfolio/background/easy.png" alt="Generic placeholder image" width="150" height="150"> 
            <h2 class="text-light">Easy to use</h2> <br><br>
            <p >Simple and beautiful layout design, fast interaction, to provide you with a high-quality experience.</p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="/../storage/img/portfolio/background/interesting.png" alt="Generic placeholder image" width="150" height="150">
            <h2 class="text-light">Interesting learning resources</h2>
            <p>An open resource sharing platform, here are interesting videos, learning materials and efficient exercises.</p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="/../storage/img/portfolio/background/interaction.jpg" alt="Generic placeholder image" width="130" height="130"> <br> <br>
            <h2 class="text-light">Funny intractive</h2> <br><br>
            <p>Interesting activity mark and comment function, do you want to compare with other students?</p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider" id="gallery">

        <div class="row featurette">
          <div class="col-md-5">
            <h2 class="featurette-heading">Easy to use. <span class="middleText" style=" text-shadow: 2px 5px 8px #F1C40F;">Come and see!</span></h2> <br>
            <p class="lead">Miss Multiple is an online learing platform for the primary student to learn multiplication in mathematics.</p>
          </div>
          <div class="col-md-7">
            <img class="featurette-image img-fluid mx-auto" src="/../storage/img/portfolio/background/easy2.png" alt="Easy to use" >
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-5 order-md-1">
            <h2 class="featurette-heading">Interesting learning resources.<span class="middleText" style="text-shadow: 2px 5px 8px #58D68D;">Oh yeah,that's great.</span></h2> <br>
            <p class="lead">An open resource staion, and also provide version for the teachers.</p>
          </div>
          <div class="col-md-7 order-md-2">
            <img class="featurette-image img-fluid mx-auto" src="/../storage/img/portfolio/background/rescource.png" alt="resource">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Happy learing.<span class="middleText" style="text-shadow: 2px 5px 8px #F1948A;">Learning is so fun and easy!</span></h2> <br>
            <p class="lead">Take a look at your activity energy. Did you have it over him today?</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" src="/../storage/img/portfolio/background/rankingBoard.png" alt="rankingBoard.png">
          </div>
        </div>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer class="container">    
        <p class="float-right"><a href="#" class="text-warning" >Back to top</a></p>
        <p>&copy; 2020-2021 Zhang Wenqi &middot; <a href="mailto:1299226721@qq.com">Email me</a></p>
      </footer>
    </main>
         
     </div>




@endsection

