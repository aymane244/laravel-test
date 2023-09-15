<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footers.css') }}">
    <link rel="stylesheet" href="{{ asset('css/anima.css') }}">
    @yield('css')
</head>
<body>

<div class="container-fluid" style="background-color: #2d1166">

    <div class="row" style="padding: 10px">
        <div class="col-xl-12">
            <div class="d-flex justify-content-between flex-wrap align-items-center">
                <div class="header-info-left" style="margin-left: 10px">
                <ul style="margin: 0;padding: 0">
                <li><i class="fa fa-phone icon_top_header" style="font-size: 16px"></i> +212 668-565681</li>
                <li>jallal.diane@gmail.com</li>
                </ul>
                </div>
                <div class="header-info-right" style="margin-right: 8px">
                <ul class="header-social" style="margin: 0;padding: 0">
                <li><a href="#"><i class="fa fa-facebook icon_top_header"></i></a></li>
                <li><a href="#"><i class="fa fa-globe icon_top_header"></i></a></li>
                <li> <a href="#"><i class="fa fa-instagram icon_top_header"></i></a></li>
                </ul>
                </div>
                </div>
        </div>
    </div>
</div>



    <nav class="navbar navbar-expand-xl navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" style="text-align:left" href="/">
                <img src="{{ asset('/img/log.jfif') }}" style="width:66px;height:60px">
                <p style="display: inline-block;line-height: 22px;margin-bottom: 10px;">Morrocan <b style="color: #2d1166">Association</b> <br> For<b style="color: #2d1166"> Entrepreneurs</b></p>
                <!--<i class="fa fa-cube" style="color: #2d1166"></i>-->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars" style="color: white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto"></ul>

                <div class="d-flex">
                    <ul class="nav navbar-nav">
                        @guest
                        <li class="nav-item margin_left">
                            <a class="nav-link nav_header" href="/">Home</a>
                        </li>
                        <li class="nav-item margin_left">
                            <a class="nav-link nav_header" href="/#services">Our Services</a>
                        </li>
                        <li class="nav-item margin_left">
                            <a class="nav-link nav_header" href="/#about">About us</a>
                        </li>
                        <li class="nav-item margin_left">
                            <a class="nav-link nav_header" href="/#contact">Contact</a>
                        </li>
                        <li style="margin-left: 20px" class="nav_btn_auth"><a href="{{ route('login') }}" style="" class="btn btn-outline-success btn_nav">Login</a></li>
                        <li style="margin-left: 10px" class="nav_btn_auth"><a href="{{ route('register') }}" style="" class="btn btn-success btn_nav2">Sign up</a></li>
                        @else
                        @if (Auth::user()->etat_compte)
                            @if (Auth::user()->isAdmin==false)
                                <li class="nav-item margin_left">
                                    {{-- <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('entreprises.index') }}"><i class="fa fa-users"></i>Entreprises</a> --}}
                                    <ul class="notification-drop">
                                        <li class="item nav-link nav_header" style="font-weight: 100;margin:0.2rem">
                                            <i class="fa fa-bell" aria-hidden="true" style="display: block;text-align: center"></i>
                                            @if($count_unread_notifications>0)
                                                <span class="btn__badge pulse-button btn_notification">{{ $count_unread_notifications }}</span>
                                            @endif
                                            Notifications
                                        <ul>
                                            <div class="list_notifications" style="max-height: 328px;overflow-y: overlay;">
                                                    @foreach ($notifications as $notification)
                                                        {{-- notification --}}
                                                            <li @if($notification->is_read==false) style="background-color: #deffb2ba;" @endif >

                                                                <i class="@if($notification->etat=='rendez_vous') fa fa-clock-o @endif @if($notification->etat=='chat_group') fa fa-envelope @endif @if($notification->etat=='recommendation') fa fa-star @endif  icon_notification" aria-hidden="true"></i>
                                                                <div class="notify_message">
                                                                    {!! html_entity_decode($notification->message) !!}
                                                                    <span class="date_notify">{{ $notification->date }}</span>
                                                                </div>
                                                            </li>
                                                        {{-- end notification --}}
                                                    @endforeach
                                            </div>
                                            <div style="text-align: center;padding: 14px 0 14px 2px;">
                                                <a href="{{ route('notify') }}" class="all_notification">All Notifications</a>
                                            </div>

                                        </ul>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li class="nav-item margin_left">
                                <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('entreprises.index') }}"><i class="fa fa-users"></i>Entreprises</a>
                            </li>
                            <li class="nav-item margin_left">
                                <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('calender') }}"><i class="fa fa-calendar"></i>Calender</a>
                            </li>
                            <li class="nav-item margin_left">
                                <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('events.index') }}"><i class="fa fa-calendar-o" aria-hidden="true"></i>Events</a>
                            </li>
                            <li class="nav-item margin_left">
                                <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('recommandation.index') }}"><i class="fa fa-star" aria-hidden="true"></i>Recommandation</a>
                            </li>
                            <li class="nav-item margin_left">
                                <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('events.create') }}"><i class="fa fa-clock-o" aria-hidden="true"></i>Rendez-vous</a>
                            </li>
                            <li class="nav-item margin_left">
                                <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('chat') }}"><i class="fa fa-envelope"></i>Conversations</a>
                            </li>
                            <li class="nav-item margin_left">
                                <a class="nav-link nav_header" style="font-weight: 100" href="{{ route('chat_groupe') }}"><i class="fa fa-envelope"></i>Conversations groupe</a>
                            </li>
                        @else
                            <li class="nav-item margin_left" style="align-self: center">
                                <a class="nav-link nav_header" style="font-weight: bolder;margin-top: 4px;" href="#">Compte :<b style="color: red;font-weight: 100"> Désactivé </b></a>
                            </li>
                        @endif


                            <li class="nav-item dropdown margin_left">
                                <a class="nav-link dropdown-toggle nav_header" style="font-weight: 100" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (auth()->user()->logo==NULL)
                                        @php
                                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                        $color = $colors[array_rand($colors)];
                                        @endphp
                                        <div class="logo_virtual" style="background-color: @php echo $color; @endphp">
                                            <h5 class="text-center" style="color: white;padding-top: 6px">@php echo substr(auth()->user()->name, 0, 1); @endphp </h5>
                                        </div>
                                    @else
                                        <img src="{{ asset('img/logos/'.Auth::user()->logo.'') }}" class="avatar" alt="{{ auth()->user()->name }}">
                                    @endif
                                   <strong style="font-size: 20px;font-weight: 100"> {{ auth()->user()->name }} </strong>  <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('entreprises.show','Profile') }}"><i class="fa fa-user-o"></i> Profile</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            <i class="material-icons">&#xE8AC;</i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')


   <footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5" style="text-align: center">
                <div class="row">
                    <div class="col-xl-4 col-md-12 mb-4">
                        <div class="single-cta">
                            <i class="fa fa-map" style="float: none;vertical-align: top"></i>
                            <div class="cta-text">
                                <h4>Find us</h4>
                                <span>Av Liban,Res Lina,1ER Étage, No 27, Tanger,Maroc</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mb-4">
                        <div class="single-cta">
                            <i class="fa fa-phone" style="float: none;vertical-align: top"></i>
                            <div class="cta-text">
                                <h4>Call us</h4>
                                <span>+212 668-565681</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mb-4">
                        <div class="single-cta">
                            <i class="fa fa-envelope-open" style="float: none;vertical-align: top"></i>
                            <div class="cta-text">
                                <h4>Mail us</h4>
                                <span>jallal.diane@gmail.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-5 pb-5">
                <div class="row" style="justify-content: space-between;">
                    <div class="col-xl-5 col-lg-5 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                {{-- <a href="index.html"><img src="https://i.ibb.co/QDy827D/ak-logo.png" class="img-fluid" alt="logo"></a> --}}
                                {{-- <a class="navbar-brand" href="/" style="color: white;font-size: 26px;"><i class="fa fa-cube" style="color: white"></i> Brand<b style="color: white">Name</b></a> --}}
                            </div>
                            <div class="footer-text">
                                <p>Moroccan Association For Entrepreneurs est une
                                    association nationale indépendante qui se consacre
                                    à la diffusion de la culture et à la promotion des
                                    activités et des pratiques entrepreneuriales, de la
                                    créativité, de l'innovation et de l'excellence aussi bien
                                    au niveau local, national qu'international. .</p>
                            </div>
                            <div class="footer-social-icon mb-4">
                                <span style="text-align: left">Follow us</span>
                                <a href="#"><i class="fa fa-facebook facebook-bg"></i></a>
                                <a href="#"><i class="fa fa-twitter twitter-bg"></i></a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-2"></div> --}}
                    <div class="col-xl-5 col-lg-5 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Useful Links</h3>
                            </div>

                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="/#services">Our Services</a></li>
                                <li><a href="/#about">About us</a></li>
                                <li><a href="/#contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>Copyright &copy; 2022, All Right Reserved <a href="https://activdigital.ma/">ActivDigital</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="/#services">Our Services</a></li>
                                <li><a href="/#about">About us</a></li>
                                <li><a href="/#contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
    @yield('script')


<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

<script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";
    $(document).ready(function () {
        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    Pusher.logToConsole = true;
    var pusher = new Pusher('128ce530439a83471d6e', {
    cluster: 'eu'
    });
    var channelName = "<?php echo 'notification-channel' ?>";

    var status = $('#id').val();

    var channelName =  'notification-channel';
    var channel = pusher.subscribe('notification-channel');

    channel.bind('App\\Events\\NotificationEvent', function(data) {
            if (my_id == data.to) {
                var etat='';
                if(data.etat=='rendez_vous') etat="fa fa-clock-o";
                if(data.etat=='chat_group') etat="fa fa-envelope";
                if(data.etat=='recommendation') etat="fa fa-star";
                $('.list_notifications').prepend("<li style='background-color: #deffb2ba;'><i class='"+etat+" icon_notification' aria-hidden='true'></i><div class='notify_message'>"+data.message+"<span class='date_notify'>"+data.date_notify+"</span></div></li>");
                var notify = parseInt($('.notification-drop .item').find('.btn_notification').html());

                    if (notify) {
                        $('.notification-drop .item').find('.btn_notification').html(notify + 1);
                    } else {
                        $('.notification-drop .item').append('<span class="btn__badge pulse-button btn_notification">1</span>');
                    }

            }
        });

        $(".notification-drop .item").on('click',function() {
            $(this).find('ul').toggle();
            $('.notification-drop .item').find('.btn_notification').remove();

            $.ajax({
                type: "get",
                url: "/notifications", // need to create this route
                data: "",
                cache: false,
                success: function (data) {
                }
            });

        });

    });

 </script>


</body>
</html>
