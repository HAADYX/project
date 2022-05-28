<!DOCTYPE html>
<html lang="en">
   <!-- Basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Mobile Metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- Site Metas -->
   <title>@lang('site.Doctors')</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- Site Icons -->
   <link rel="shortcut icon" href="{{asset('website/images/fevicon.ico.png')}}" type="image/x-icon" />
   <link rel="apple-touch-icon" href="{{asset('website/images/apple-touch-icon.png')}}">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="{{asset('website/css/bootstrap.min.css')}}">
   <!-- Site CSS -->
   <link rel="stylesheet" href="{{asset('website/style.css')}}">
   <!-- Colors CSS -->
   <link rel="stylesheet" href="{{asset('website/css/colors.css')}}">
   <!-- ALL VERSION CSS -->
   <link rel="stylesheet" href="{{asset('website/css/versions.css')}}">
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="{{asset('website/css/responsive.css')}}">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="{{asset('website/css/custom.css')}}">
   <!-- Modernizer for Portfolio -->
   <script src="{{asset('website/js/modernizer.js')}}"></script>
   <!-- [if lt IE 9] -->
   </head>
   <body class="clinic_version">
      
      <div id="preloader">
         <img class="preloader" src="{{asset('website/images/loaders/heart-loading2.gif')}}" alt="">
      </div>

      <header>
         <div class="header-bottom wow fadeIn">
            <div class="container">
               <nav class="main-menu">
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i class="fa fa-bars" aria-hidden="true"></i></button>
                  </div>
				  
                  <div id="navbar" class="navbar-collapse collapse">
                     <ul class="nav navbar-nav">
                        <li><a class="active" href="{{route('index')}}">Home</a></li>

                        @guest
                        <li>
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>

                        @if (Route::has('register'))
                            <li>
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif 
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                     </ul>
                  </div>
               </nav>
               <div class="serch-bar">
                  <div id="custom-search-input">
                     <div class="input-group col-md-12">
                        <form action="{{route('index')}}" method="GET">
                            @csrf
                            <input type="text" name='text' class="form-control input-lg" placeholder="Search" />
                            <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                            </span>
                        </form>    
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>

      <div id="home" class="parallax first-section wow fadeIn" data-stellar-background-ratio="0.4" style="background-image:url('{{asset('website/images/slider-bg.png')}}');">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="text-contant">
                     <h2>
                        <span class="center"><span class="icon"><img src="{{asset('website/images/icon-logo.png')}}" alt="#" /></span></span>
                        <a href="" class="typewrite" data-period="2000" data-type='[ "Welcome to Cardiology_department", "We Care Your Health", "We are Expert!" ]'>
                        <span class="wrap"></span>
                        </a>
                     </h2>
                  </div>
               </div>
            </div>
            <!-- end row -->
         </div>
         <!-- end container -->
      </div>
   
	  <div class="col-md-">
        <form action="{{route('index')}}" method="GET">
            @csrf
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="form-group">
                    <select id="category_id" name="category_id"  class='form-control'>
                        @foreach ($categories as $cat)
                        <option value="">Choose Specialist</option>
                            <option value="{{$cat->id}}" {{ (request()->category_id==$cat->id  ) ? 'selected' : '' }}>{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>    
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="text" value="{{request()->text}}" placeholder="Doctor Name">
                </div>    
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Send" style="color: white;">
                </div>    
            </div>
            <div class="col-md-2"></div>
        </form>
      </div>


	  <div id="doctors" class="parallax section db" data-stellar-background-ratio="0.4" style="background:#fff;" data-scroll-id="doctors" tabindex="-1">
        <div class="container">
		
		<div class="heading">
               <span class="icon-logo"><img src="{{asset('website/images/icon-logo.png')}}" alt="#"></span>
               <h2>The Specialist Clinic</h2>
            </div>

            <div class="row dev-list text-center">
                @if($doctors->count() > 0)
                    @foreach($doctors as $doctor)
                        @php $user=\App\User::where('hotel_id',$doctor->id)->first();@endphp
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
                            <div class="widget clearfix">
                                {{-- <img src="{{$user->image_path}}" alt="" class="img-responsive img-rounded"> --}}
                                <div class="widget-title">
                                    <h3>{{$doctor->name}}</h3>
                                    <small>{{$doctor->category->name}}</small>
                                </div>
                                <!-- end title -->
                                <p>{!! $doctor->description !!}</p>

                                <div class="footer-social">
                                    <a href="{{route('book',$doctor->id)}}" class="btn grd1"><i class="fa fa-clock-o" style="margin-right: 5px"></i>Book Now</a>
                                </div>
                            </div><!--widget -->
                        </div>
                    @endforeach    
                    {{$doctors->links()}}
                @else

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
                        <div class="widget clearfix">
                            <img src="{{asset('website/images/doctor_01.jpg')}}" alt="" class="img-responsive img-rounded">
                            <div class="widget-title">
                                <h3>Soren Bo Bostian</h3>
                                <small>Clinic Owner</small>
                            </div>
                            <!-- end title -->
                            <p>Hello guys, I am Soren from Sirbistana. I am senior art director and founder of Violetta.</p>

                            <div class="footer-social">
                                <a href="#" class="btn grd1"><i class="fa fa-clock-o" style="margin-right: 5px"></i>Book Now</a>
                            </div>
                        </div><!--widget -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.4s; animation-name: fadeIn;">
                        <div class="widget clearfix">
                            <img src="{{asset('website/images/doctor_02.jpg')}}" alt="" class="img-responsive img-rounded">
                            <div class="widget-title">
                                <h3>Bryan Saftler</h3>
                                <small>Internal Diseases</small>
                            </div>
                            <!-- end title -->
                            <p>Hello guys, I am Soren from Sirbistana. I am senior art director and founder of Violetta.</p>

                            <div class="footer-social">
                                <a href="#" class="btn grd1"><i class="fa fa-clock-o" style="margin-right: 5px"></i>Book Now</a>
                            </div>
                        </div><!--widget -->
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn">
                        <div class="widget clearfix">
                            <img src="{{asset('website/images/doctor_03.jpg')}}" alt="" class="img-responsive img-rounded">
                            <div class="widget-title">
                                <h3>Matthew Bayliss</h3>
                                <small>Orthopedics Expert</small>
                            </div>
                            <!-- end title -->
                            <p>Hello guys, I am Soren from Sirbistana. I am senior art director and founder of Violetta.</p>

                            <div class="footer-social">
                                <a href="#" class="btn grd1"><i class="fa fa-clock-o" style="margin-right: 5px"></i>Book Now</a>
                            </div>
                        </div><!--widget -->
                    </div><!-- end col -->
                
                @endif
            </div><!-- end row -->
        </div><!-- end container -->
    </div>

      <div class="copyright-area wow fadeIn">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <div class="footer-text">
                     <p>© 2018 Doctors. All Rights Reserved.</p>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="social">
                     <ul class="social-links">
                        <li><a href=""><i class="fa fa-rss"></i></a></li>
                        <li><a href=""><i class="fa fa-facebook"></i></a></li>
                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                        <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                        <li><a href=""><i class="fa fa-youtube"></i></a></li>
                        <li><a href=""><i class="fa fa-pinterest"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>


      <!-- end copyrights -->
      <a href="#home" data-scroll class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>
      <!-- all js files -->
      <script src="{{asset('website/js/all.js')}}"></script>
      <!-- all plugins -->
      <script src="{{asset('website/js/custom.js')}}"></script>
      <!-- map -->
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNUPWkb4Cjd7Wxo-T4uoUldFjoiUA1fJc&callback=myMap"></script>
   </body>
</html>
