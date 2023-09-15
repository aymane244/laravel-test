@extends('layouts.app')
@section('title') Conversations @endsection
@section('css')
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<!-- Styles -->
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

    <div class="mt-5" style="text-align: center;margin-bottom: 90px">
        <h1 style="font-weight: 900">Conversation</h1>
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
            <style>

            </style>
            <div id="contacts">
                <ul style="padding-left: 0px">
                    @foreach($users as $user)
                        <li class="contact user" id="{{ $user->id }}">

                            <div class="wrap">
                                @if ($user->logo==null)
                                    @php
                                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                        $color = $colors[array_rand($colors)];
                                    @endphp
                                    <div class="logo_virtual_chat" style="background-color: @php echo $color; @endphp">
                                        <h4 class="text-center" style="color: white;padding-top: 9px">@php echo substr($user->name, 0, 1); @endphp </h4>
                                    </div>
                                @else
                                    <img src="{{ asset('img/logos/'.$user->logo.'') }}" alt="{{ $user->name }}" />
                                @endif

                                <div class="meta">
                                    <p class="name">{{ $user->name }}</p>
                                    <p class="preview">{{ $user->email }}</p>
                                </div>
                                @if($user->unread>0)
                                    <button type="button" class="icon-button button_notification">
                                        <div class="material-icons" style="font-size: 20px">notifications</div>
                                        <div class="icon-button__badge pending_chat">{{ $user->unread }}</div>
                                    </button>
                                    {{-- <span class="pending">{{ $user->unread }}</span> --}}
                                @endif

                                {{-- notification small --}}
                                @if($user->unread>0)
                                    <div class="icon-button_badge pending_chat_sm" style="display: none;width: fit-content;">
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
                <div class="social-media" style="font-size: 15px">
                    <a href="{{ Auth::user()->facebook }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="{{ Auth::user()->instagram }}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="{{ Auth::user()->website }}" style="margin-right: 20px" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="messages" id="messages">
                <div style="text-align: center;padding-top: 50px;">
                    <img src="{{ asset('img/c4.png') }}" class="mx-auto img_chat" style="">
                </div>

            </div>
            <div class="message-input">
                <div class="wrap">

                    <input type="text" style="padding: 23px 32px 15px 21px;" placeholder="Write your message..." />

                    <a id="file-input-button-x" href="#" style="display: none" class="file-input-button"> <i class="fa fa-paperclip attachment" aria-hidden="true"></i> </a>
                    <input id="file_message" class="file-input visually-hidden" type="file" name="file_message" />
                    <button class="submit btn_send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    <div id="input_message" class="box_message_file" style="">
                        <p id="file_name_message" style=""></p>
                        <div class="icon-button__badge" id="close_file_message" onclick="close_file_message()"><i class="fa fa-times-circle" style="color: white;" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
$(".messages").animate({ scrollTop: $(document).height() }, "fast");

    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function() {
      $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");

        if($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        };

        $("#status-options").removeClass("active");
    });


    </script>



<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    var receiver_id = '';
    var file_message = null;
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
    var channelName = "<?php echo 'notify-channel' ?>";

    var status = $('#id').val();

    var channelName =  'notify-channel';
    var channel = pusher.subscribe('notify-channel');
    channel.bind('App\\Events\\Notify', function(data) {
      //  alert(JSON.stringify(data));
            if (my_id == data.from) {
                $('#' + data.to).click();
            } else if (my_id == data.to) {
                if (receiver_id == data.from) {
                    // if receiver is selected, reload the selected user ...
                    $('#' + data.from).click();
                } else {

                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#' + data.from).find('.pending_chat').html());
                    var pending_sm = parseInt($('#' + data.from).find('.notification_num').html());

                    if (pending) {
                        $('#'+data.from+' .wrap').find('.pending_chat').html(pending + 1);
                    } else {
                        $('#'+data.from+' .wrap').append('<button type="button" class="icon-button button_notification"> <div class="material-icons" style="font-size: 20px">notifications</div><div class="icon-button__badge pending_chat">1</div></button>');
                    }

                    if (pending_sm) {
                        $('#'+data.from+' .wrap').find('.notification_num').html(pending_sm + 1);
                    } else {
                        $('#'+data.from+' .wrap').append('<div class="icon-button_badge pending_chat_sm" style="display: none;width: fit-content;"><p style="margin-top: -2px;" class="notification_num">1</p></div>');
                    }

                }
            }
        });

        $('.user').click(function () {
            $('#file-input-button-x').css('display','block');
            $('.user').removeClass('active');
            $(this).addClass('active');
            // $(this).find('.pending_chat').remove();
            $(this).find('.button_notification').remove();
            $(this).find('.pending_chat_sm').remove();

            receiver_id = $(this).attr('id');
            // alert(receiver_id);
            $.ajax({
                type: "get",
                url: "chat/" + receiver_id, // need to create this route
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);
                    scrollToBottomFunc();
                }
                
            });
        });


        $(document).on('keyup', '.message-input .wrap input', function (e) {
            var message = $(this).val();
            // check if enter key is pressed also receiver is selected
            if (e.keyCode == 13 && receiver_id != '') {
                $(this).val(''); // while pressed enter text box will be empty
                var myFormData = new FormData();
                if(message!='')  myFormData.append('message', message);
                else  myFormData.append('message', null);
                if(file_message==null) myFormData.append('file_message', "not_exist");
                else myFormData.append('file_message', file_message);
                myFormData.append('receiver_id', receiver_id);
                $.ajax({
                    url: 'chat',
                    type: 'POST',
                    processData: false, // important
                    contentType: false, // important
                    dataType : 'json',
                    data: myFormData,
                    success: function (data) {  },
                    error: function (jqXHR, status, err) { },
                    complete: function () {
                        scrollToBottomFunc();
                    }
                });
                close_file_message();
            }
        });

        $( ".btn_send" ).click(function() {
            var message = $('.message-input .wrap input').val();
             // check if enter key is pressed and message is not null also receiver is selected
            if (receiver_id != '' && (message!='' || file_message!=null)) {
                $('.message-input .wrap input').val(''); // while pressed enter text box will be empty
                var myFormData = new FormData();
                if(message!='')  myFormData.append('message', message);
                else  myFormData.append('message', null);
                if(file_message==null) myFormData.append('file_message', "not_exist");
                else myFormData.append('file_message', file_message);
                myFormData.append('receiver_id', receiver_id);
                $.ajax({
                    url: 'chat',
                    type: 'POST',
                    processData: false, // important
                    contentType: false, // important
                    dataType : 'json',
                    data: myFormData,
                    success: function (data) { },
                    error: function (jqXHR, status, err) {},
                    complete: function () {
                        scrollToBottomFunc();
                    }
                });
                close_file_message();
            }
        });

    });

    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.messages').animate({
            scrollTop: $('.messages').get(0).scrollHeight
        }, 500);
    }
    function close_file_message(){
        $('#file-input-button-x').css('display','block');
        $('.box_message_file').css('display','none');
        file_message=null;
    }


    $(function(){
        $('#file_message').on('change', function(e){
            var file = this.files[0];
            file_message=file;
            $('#file_name_message').html(file_message.name);
        })

        $('.file-input-button').on('click', function(e){
            $('#file-input-button-x').css('display','none');
            $('.box_message_file').css('display','block');
            $( '#file_message').trigger('click');
        })
    })


</script>
@endsection
