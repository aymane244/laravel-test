@extends('layouts.app')
@section('title') Login @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login_registre.css') }}">
@endsection

@section('content')

    @if (!($errors->isEmpty()))
        <div class="boucle_alerts">
            @foreach ($errors->all() as $message)
                <div class="form-alerts toasts" style="position: static">
                    <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-cube" style="color: white;font-size: 30px"></i>
                            <p><b class="d-flex">{{ $message }}.</b></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="container_login_register">
        <div class="wrapper">
          <form action="{{ route('login') }}" method="POST">
            @csrf
            <h1>Login</h1>
            <p>If you are already a member, easily log in</p>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email">
            <div class="pass-icon">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Password">
            </div>

            <a href="{{ route('password.request') }}">Forgot my password</a>
            <input type="submit" id="login-btn" value="Login">

            <div class="or">
              <hr>
              <span>OR</span>
              <hr>
            </div>
            <div class="register">
              <p>If you don't have an account</p>
              <a href="{{ route('register') }}" class="register-btn">Register</a>
            </div>
          </form>

        </div>

        <div class="main-img"></div>
      </div>
@endsection

@section('script')
    @if (!($errors->isEmpty()))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif
@endsection
