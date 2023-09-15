@extends('layouts.app')

@section('title') Reset Password @endsection
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
            <form action="{{ route('password.update') }}" method="POST">
            @csrf
                <h1>Reset Password</h1>
                <input type="hidden" name="token" value="{{ $token }}">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}"  required autofocus placeholder="Enter your email" >
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password ">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                <input type="submit" id="login-btn" value="Send Password Reset Link">
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
