<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Customer Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
      
        
    </head>
    <body >
        <div class="limiter">
            <div class="container-login100" style="background-image: url('{{asset('images/bg-01.jpg')}}');">
                <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('message'))
                    <div class="alert alert-{{Session::get('class')}} alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <form class="login100-form validate-form"  method="post" action="{{url('sign-in')}}">
                    @csrf
                        <span class="login100-form-title p-b-49">
                            Login
                        </span>

                        <div class="wrap-input100 validate-input m-b-23" data-validate="Username is reauired">
                            <span class="label-input100">Username</span>
                            <input class="input100 has-val" type="text" name="username" placeholder="Type your username" value="">
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <span class="label-input100">Password</span>
                            <input class="input100 has-val" type="password" name="password" placeholder="Type your password" value="">
                        </div>
                        
                        <div class="text-right p-t-8 p-b-31">
                            <a >
                               &nbsp;
                            </a>
                        </div>
                        
                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn">
                                    Login
                                </button>
                            </div>
                        </div>       
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
