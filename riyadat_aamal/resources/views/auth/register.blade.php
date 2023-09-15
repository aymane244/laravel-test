@extends('layouts.app')

@section('title') Registre @endsection
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
          <form action="{{ route('register') }}" method="POST">
            @csrf
            <h1>Register</h1>
            <p>If you are already a member, easily log in</p>

            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter Name ">
            <input id="tele" type="numbre" class="form-control @error('tele') is-invalid @enderror" name="tele" value="{{ old('tele') }}" required autocomplete="tele" autofocus placeholder="Enter Numero Telephone">
            <input id="adress" type="text" class="form-control @error('adress') is-invalid @enderror" name="adress" value="{{ old('adress') }}" required autocomplete="adress" autofocus placeholder="Enter Adress">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email">
            <div class="pass-icon">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Password">
            </div>
            <div class="pass-icon">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmation Password">
            </div>
            <a href="{{ route('password.request') }}">Forgot my password</a>
            <input type="submit" id="login-btn" value="Registre">
            <div class="or">
              <hr>
              <span>OR</span>
              <hr>
            </div>
            <div class="register">
              <p>If you have an account</p>
              <a href="{{ route('login') }}" type="submit" class="register-btn">Login</a>
            </div>
          </form>
        </div>
        <div class="main-img mt-5"></div>
    </div>

@endsection

@section('script')
    @if (!($errors->isEmpty()))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif
@endsection
