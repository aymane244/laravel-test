<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('css/dashboard/circular-std/style.css') }} " rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard/libs/css/style.css') }} ">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
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

    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
                {{-- <a href="#"><img class="logo-img" src="{{ asset('img/logo.png') }}" alt="logo"></a> --}}
                <p style="display: inline-block;line-height: 22px;margin-bottom: 10px;font-size:20px">Morrocan <b style="color: #2d1166">Association</b> <br> For<b style="color: #2d1166"> Entrepreneurs</b></p>
                <span class="splash-description">Please enter Admin information.</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" name="password" required placeholder="Enter Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/dashboard/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstap bundle js -->
    <script src="{{ asset('js/dashboard/bootstrap/js/bootstrap.bundle.js') }} "></script>
    @if (!($errors->isEmpty()))
    <script type="text/javascript">
        setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
    </script>
    @endif
</body>

</html>
