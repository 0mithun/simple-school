<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} </title>

        <!-- Bootstrap -->
        <link href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        
        
        <link href="{{asset('assets')}}/vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link href="{{asset('assets')}}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" />
   
        @yield('stylesheet')
        <!-- Custom Theme Style -->
        <link href="{{asset('assets')}}/build/css/custom.min.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('assets') }}/style.css" rel="stylesheet">


    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="{{ route('dashboard.index')  }}" class="site_title"><img  class="app_logo" src="{{$app_setup->app_logo}}" /> </a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img class="loged_in_user_photo img-circle profile_img"  src="{{asset(Auth::user()->user_photo)}}" alt="">
                                
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2  class="loged_in_user_name">{{ ucwords(Auth::user()->name) }}</h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />
                       
                        @include('partial.sidebar')
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                @include('partial.topnav')

                @include('partial.profilemodal')
                <!-- /top navigation -->
                @yield('content')
                <!-- footer content -->
                <div class="clearfix clear"></div>

            </div>
        </div>

        <footer>
            <div class="pull-right" style="">Gentelella - Bootstrap Admin Template <a href="#">Colorlib </a></div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
        <!-- jQuery -->
        
        <script src="{{asset('assets')}}/vendors/jquery/dist/jquery.min.js"></script>
        <script src="{{asset('assets')}}/js/jquery-ui.min.js"></script>
        
        <script src="{{asset('assets')}}/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
        
        <!-- Bootstrap -->
        <script src="{{asset('assets')}}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>


        <!-- the main fileinput plugin file -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/themes/fa/theme.js"></script>
        <!-- Custom Theme Scripts -->

        
        
        @yield('script');
            <!-- Custom Theme Scripts -->
        <script src="{{asset('assets')}}/build/js/custom.min.js"></script>
    
        @include('partial.commonjs')
    </body>
</html>
