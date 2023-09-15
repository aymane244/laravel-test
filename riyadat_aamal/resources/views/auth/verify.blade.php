@extends('layouts.app')
@section('title') Verify @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/login_registre.css') }}">
@endsection

@section('content')

    @if (session('resent'))
        <div class="form-alerts toasts">
            <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">
                <div class="d-flex align-items-center">
                    <i class="fa fa-cube" style="color: white;font-size: 30px"></i>
                    <p><b class="d-flex">A fresh verification link has been sent to your email address..</b></p>
                </div>
            </div>
        </div>
    @endif

    <div class="container_login_register">
        <div class="wrapper" style="margin-right: 20px">
            <div class="card">
                <div class="card-header">Verify Your Email Address</div>
                <div class="card-body">
                    Before proceeding, please check your email for a verification link. If you did not receive the email
                <div class="or">
                    <hr> <span></span> <hr>
                </div>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    {{-- <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>. --}}
                    <input type="submit" id="login-btn" value="click here to request another" style="font-size: 20px;width: 380px">
                </form>
                </div>
            </div>
        </div>

        <div class="main-img"></div>
    </div>

@endsection

@section('script')
    @if (session('resent'))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif
@endsection
