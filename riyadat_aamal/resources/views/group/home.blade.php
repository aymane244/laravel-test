@extends('layouts.ChatGroup')
@section('css')
    <!-- Scripts -->
   <script src="{{ asset('js/app.js') }}" defer></script>
   <!-- Fonts -->
   <link rel="dns-prefetch" href="//fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
   {{-- <link rel="stylesheet" href="{{ asset('css/login_registre.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/entreprises.css') }}">
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .nav-link .logo_virtual h5{
            padding-top: 8px !important;
        }
    </style>
@endsection

@section('content')

{{-- Message error et session --}}
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

@if (session('message'))
    <div class="boucle_alerts">
    <div class="form-alerts toasts" style="position: static">
        <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">
        <div class="d-flex align-items-center">
            <i class="fa fa-cube" style="color: white;font-size: 30px"></i>
            <p><b class="d-flex">{{ session('message') }}. <i class="fa fa-check-circle" aria-hidden="true" style="color:white;margin-left:10px;font-size:23px"></i></b></p>
        </div>
        </div>
    </div>
    </div>
@endif

{{-- Modal confirmation et update --}}
<div class="window" style="display: none"></div>
{{-- modal confirmation  --}}
<div id="myModal" class="modal_confirm modal">
    <div class="modal-dialog modal-confirm modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <div class="icon-box">
            <i  id="icon_traitement" class="fa fa-trash"></i>
        </div>
        <h4 class="modal-title mx-auto">Êtes-vous sûr? </h4>
        <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">&times;</button>
        </div>
        <div class="modal-body">
            <p id="p_confirmation"></p>
        </div>

        <div class="modal-footer mx-auto">
            <button class="btn btn-info" onclick="$('.window').css('display','none');$('.modal').css('display','none');">Cancel</button>
            <button class="btn btn-danger" id="submit_confirmation">Delete</button>
        </div>

        <form id="delete_groupe_form" action="/group/delete" method="POST" class="d-none">
            @csrf
            <input type="hidden" class="id_groupe_delete" name="id">
        </form>
        <form id="quitter_groupe_form" action="/unFollow" method="POST" class="d-none">
            @csrf
            <input type="hidden" class="id_groupe_delete" name="id">
        </form>

    </div>
    </div>
</div>

<div class="mt-5" style="text-align: center;margin-bottom: 90px">
    <h1 style="font-weight: 900">Conversation groupes</h1>
    <div class="h-divider-title">
        <div class="shadow"></div>
    </div>
</div>

<div id="frame" class="wow fadeIn" data-wow-duration="1.5s">
    <div id="sidepanel">
        <div id="profile">
            <div class="wrap">
                @if (Auth::user()->logo==null)
                    @php
                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                        $color = $colors[array_rand($colors)];
                    @endphp
                    <div class="logo_virtual_chat" style="margin-right: 0px;width:50px;height: 50px;background-color: @php echo $color; @endphp">
                        <h4 class="text-center" style="color: white;padding-top: 12px">@php echo substr(auth()->user()->name, 0, 1); @endphp </h4>
                    </div>
                @else
                    <img id="profile-img" src="{{ asset('img/logos/'.Auth::user()->logo.'') }}" class="online" alt="{{ Auth::user()->name }}" />
                @endif

                <p>{{ Auth::user()->name }}</p>
                <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                <div id="expanded">
                    <label for="email"><i class="fa fa-at fa-fw" aria-hidden="true" ></i></label>
                    <input name="email" type="text" value="{{ Auth::user()->email }}" disabled />
                    <label for="tele"><i class="fa fa-phone fa-fw" aria-hidden="true"></i></label>
                    <input name="tele" type="text" value="{{ Auth::user()->tele }}" disabled/>
                    <label for="type"><i class="fa fa-newspaper-o fa-fw" aria-hidden="true"></i></label>
                    <input name="type" type="text" value="{{ Auth::user()->type_entreprise }}" disabled/>
                </div>
            </div>
        </div>
        <div id="contacts">
            <ul style="padding-left: 0px">
                @foreach($users as $user)
                    <li class="contact user" id="{{ $user->id }}">

                        <div class="wrap">
                            @php
                                $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                $color = $colors[array_rand($colors)];
                            @endphp
                            <div class="logo_virtual_chat" style="background-color: @php echo $color; @endphp">
                                <h4 class="text-center" style="color: white;padding-top: 9px;text-transform: uppercase;">@php echo substr($user->name, 0, 1); @endphp </h4>
                            </div>
                            <div class="meta">
                                <p class="name">{{ $user->name }}</p>
                                <p class="">Admin : {{ $user->name_entreprise }}</p>
                            </div>

                            @if($user->unread>0)
                                <button type="button" class="icon-button button_notification">
                                    <div class="material-icons" style="font-size: 20px">notifications</div>
                                    <div class="icon-button__badge pending_chat">{{ $user->unread }}</div>
                                </button>
                            @endif

                            @if($user->unread>0)
                                <div class="icon-button__badge pending_chat_sm" style="display: none;width: fit-content;">
                                    <p style="margin-top: -2px;" class="notification_num">{{ $user->unread }}</p>
                                </div>
                            @endif
                        </div>

                    </li>
                @endforeach
            </ul>
        </div>
        <div id="bottom-bar">
            <a id="addcontact" href="/group/create"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span>Créer un group</span></a>
            <a id="settings" href="/subscribe"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>Rejoindre un groupe </span></a>
            <a id="settings" href="/confirmer_demande"><i class="fa fa-users" aria-hidden="true"></i> <span>Les demandes de rejoinder </span></a>
        </div>
    </div>
    <div class="content">
        <div id="content_groupe">
            <div class="contact-profile">
                @if (Auth::user()->logo==null)
                    @php
                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                        $color = $colors[array_rand($colors)];
                    @endphp
                    <div class="logo_virtual_chat" style="margin: 9px 12px 0 9px;;background-color: @php echo $color; @endphp">
                        <h5 class="text-center" style="color: white;padding-top: 11px">@php echo substr(auth()->user()->name, 0, 1); @endphp </h5>
                    </div>
                @else
                    <img src="{{ asset('img/logos/'.Auth::user()->logo.'') }}" alt="{{ Auth::user()->name }}" />
                @endif

                <p>{{ Auth::user()->name }}</p>

                <div class="social-media" style="font-size: 20px">
                    <a href="{{ Auth::user()->facebook }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="{{ Auth::user()->instagram }}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="{{ Auth::user()->website }}" style="margin-right: 20px" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
                </div>

            </div>
            <div class="messages" id="messages">
                {{-- Messages --}}
                <div style="text-align: center;padding-top: 50px;">
                    <img src="{{ asset('img/c4.png') }}" class="mx-auto img_chat" style="">
                </div>
            </div>
        </div>

        <div class="message-input">
            <div class="wrap">
                <input type="text" placeholder="Write your message..." />

                <a id="file-input-button-x" href="#" style="display: none" class="file-input-button"> <i class="fa fa-paperclip attachment" style="top: -5px" aria-hidden="true"></i> </a>
                <input id="file_message" class="file-input visually-hidden" type="file" name="file_message" />
                <button class="submit btn_send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                <div id="input_message" class="box_message_file" style="">
                    <p id="file_name_message" style=""></p>
                    <div class="icon-button__badge" id="close_file_message" onclick="close_file_message()"><i class="fa fa-times-circle" style="color: white;" aria-hidden="true"></i></div>
                </div>
                <input type="hidden" name="id" id='id' class="submit" value=''>
            </div>
        </div>
    </div>
</div>

@endsection
