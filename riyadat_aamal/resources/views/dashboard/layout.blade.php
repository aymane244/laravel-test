<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('css/dashboard/circular-std/style.css') }} " rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard/libs/css/style.css') }} ">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard/chartist.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/dashboard/c3.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/anima.css') }}">
    @yield('css')
    <title>@yield('title')</title>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
               <p style="display: inline-block;
    line-height: 22px;
    margin-bottom: 10px;
    color: black;
    font-size: 22px;
    font-weight: 900;
    padding: 9px 10px 9px 26px;">Morrocan <b style="color: #2d1166">Association</b> <br> For<b style="color: #2d1166"> Entrepreneurs</b></p>
                <button class="navbar-toggler btn_collapse_dash" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon icon_menu_collapse_dash"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->logo==null)
                                    <img src="{{ asset('img/logos/img_avatar.png') }}" alt="" class="user-avatar-md rounded-circle">
                                @else
                                    <img src="{{ asset('img/logos/'.Auth::user()->logo.'') }}" alt="" class="user-avatar-md rounded-circle">
                                @endif

                            </a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->name }} </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="fa fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off mr-2"></i>Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('dashboard.index') }}"  ><i class="fa fa-desktop" aria-hidden="true"></i>Dashboard</a>
                                <a class="nav-link" href="{{ route('dashboard.create') }}"  ><i class="fa fa-address-card" aria-hidden="true"></i>Activation D'entreprises</a>
                                <a class="nav-link" href="{{ route('dashboard.show','List') }}"  ><i class="fa fa-users" aria-hidden="true"></i>Liste D'entreprises</a>
                                <a class="nav-link" href="{{ route('dashboard.contacts') }}"  ><i class="fa fa-envelope-open" aria-hidden="true"></i>Contact</a>
                                <a class="nav-link" href="{{ route('dashboard.profile') }}"  ><i class="fa fa-user-circle"></i>Account</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        @yield('content')

    </div>

    <script src=" {{ asset('js/wow.min.js') }}  "></script>
    <script type="text/javascript">
			wow = new WOW(
              {
              boxClass:     'wow',      // default
              animateClass: 'animated', // default
              offset:       100,          // default
              mobile:       true,       // default
              live:         true        // default
            }
            )
            wow.init();

    </script>
    <script src="{{ asset('js/dashboard/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/bootstrap/js/bootstrap.bundle.js') }} "></script>
    <script src="{{ asset('js/dashboard/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/dashboard/chartist.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/C3chartjs.js') }} "></script>
    @yield('script')
</body>

</html>
