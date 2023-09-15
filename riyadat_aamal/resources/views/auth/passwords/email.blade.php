@extends('layouts.app')

@section('title') Reset Password @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login_registre.css') }}">
@endsection

@section('content')

    @if ($errors->has('email') || session('status'))
        <div class="boucle_alerts">
            @error('email')
                <div class="form-alerts toasts" style="position: static">
                    <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-cube" style="color: white;font-size: 30px"></i>
                            <p><b class="d-flex">{{ $message }}.</b></p>
                        </div>
                    </div>
                </div>
            @enderror

            @if (session('status'))
                <div class="form-alerts toasts" style="position: static">
                    <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-cube" style="color: white;font-size: 30px"></i>
                            <p><b class="d-flex">{{ session('status') }}.</b></p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="container_login_register">
        <div class="wrapper">
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <h1>Reset Password</h1>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email">
                <input type="submit" id="login-btn" value="Send Password Reset Link">
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
    @if ($errors->has('email') || session('status'))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif
@endsection
