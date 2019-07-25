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

    <title>{{ config('app.name', 'School Management System') }}</title>

        <!-- Bootstrap -->
        <link href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

        <link href="{{asset('assets/build/css/custom.min.css')}}" rel="stylesheet">
        <style>
            .error{
                color:red;
            }
        </style>
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <h1>Login</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}" required autofocus />

                                @if ($errors->has('email'))
                                <span class="help-block error">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div>
                                <input type="password" class="form-control" name="password" placeholder="Password" required="" />

                                @if ($errors->has('password'))
                                <span class="help-block error">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div>
                                <input class="btn btn-default" value="Log In" type="submit" />
                                <a class="reset_pass" href="{{ route('password.request') }}">Lost your password?</a>
                            </div>

                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>