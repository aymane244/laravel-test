@extends('layouts.app')
<title>@yield('title')</title>

@section('css')

    <script src="{{asset('js/app.js')}}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    @yield('css')

    <style>
         .chat-box: {
        padding: 10px, 20px, 10px, 20px;
        border: 0.5px solid red;
        }
</style>
@endsection

@section('content')
    @yield('content')
@endsection

@section('script')

<script>$(".messages").animate({ scrollTop: $(document).height() }, "fast");

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
    var my_id = "{{ Auth::id() }}";
    var file_message = null;
    $(document).ready(function () {
        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher('128ce530439a83471d6e', {
    cluster: 'eu'
    });

    var status = my_id;
    var channel = pusher.subscribe(status);
    channel.bind('App\\Events\\Notify', function(data) {
        //alert(JSON.stringify(data));
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
                        $('#' + data.from+' .wrap').find('.pending_chat').html(pending + 1);
                    } else {
                        $('#' + data.from+' .wrap').append('<button type="button" class="icon-button button_notification"> <div class="material-icons" style="font-size: 20px">notifications</div><div class="icon-button__badge pending_chat">1</div></button>');
                    }

                    if (pending_sm) {
                        $('#'+data.from+' .wrap').find('.notification_num').html(pending_sm + 1);
                    } else {
                        $('#'+data.from+' .wrap').append('<div class="icon-button_badge pending_chat_sm" style="display: none;width: fit-content;"><p style="margin-top: -2px;" class="notification_num">1</p></div>');
                    }

                }
            }
        });

         // get message of each Group by click
        $('.user').click(function () {
            $('#file-input-button-x').css('display','block');
            $('.user').removeClass('active');
            $(this).addClass('active');
            $(this).find('.button_notification').remove();
            $(this).find('.pending_chat_sm').remove();
            $('#id').val($(this).attr('id'));
            receiver_id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "messag/" + receiver_id,
                data: "",
                cache: false,
                success: function (data) {
                    $('#content_groupe').html(data);
                    scrollToBottomFunc();
                },
                error: function (jqXHR, status, err) {
                },
            });
        });
      // add nem message
        $(document).on('keyup', '.message-input .wrap input', function (e)
        {       // message
            // $("input").css("background-color", "yellow");
            var message = $(this).val();
            var id = $('#id').val();

            // check if enter key is pressed and message is not null also receiver is selected auth
            if (e.keyCode == 13 && id != '') {
                $(this).val(''); // while pressed enter text box will be empty

                var myFormData = new FormData();
                if(message!='')  myFormData.append('message', message);
                else  myFormData.append('message', null);
                if(file_message==null) myFormData.append('file_message', "not_exist");
                else myFormData.append('file_message', file_message);
                myFormData.append('id', id);
                $.ajax({
                    url: 'chat_groupe',
                    type: 'POST',
                    processData: false, // important
                    contentType: false, // important
                    dataType : 'json',
                    data: myFormData,
                    success: function (data) {  },
                    error: function (jqXHR, status, err) {},
                    complete: function () {
                        scrollToBottomFunc();
                    }
                });
                close_file_message();
            }
        });
        $( ".btn_send" ).click(function() {

            // $("input").css("background-color", "yellow");
            var message = $('.message-input .wrap input').val();
            var id = $('#id').val();

            // check if enter key is pressed and message is not null also receiver is selected auth
            if (id != '' && (message!='' || file_message!=null)) {

                $('.message-input .wrap input').val(''); // while pressed enter text box will be empty
                var myFormData = new FormData();
                if(message!='')  myFormData.append('message', message);
                else  myFormData.append('message', null);
                if(file_message==null) myFormData.append('file_message', "not_exist");
                else myFormData.append('file_message', file_message);
                myFormData.append('id', id);
                $.ajax({
                    url: 'chat_groupe',
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
        }, 50);
    }
function close_file_message(){
        $('#file-input-button-x').css('display','block');
        $('.box_message_file').css('display','none');
        file_message=null;
}
</script>

<script>
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

<script>
    function confirmer(id,traitement){

        if(traitement=='quitter_groupe'){
            $('#p_confirmation').html('Voulez-vous vraiment quitter cette groupe? Ce processus ne peut pas être annulé.');
            $("#submit_confirmation").attr( "onclick", "event.preventDefault();document.getElementById('quitter_groupe_form').submit();" );
        }
        else{
            $("#submit_confirmation").attr( "onclick", "event.preventDefault();document.getElementById('delete_groupe_form').submit();" );
            $('#p_confirmation').html('Voulez-vous vraiment supprimer cette groupe? Ce processus ne peut pas être annulé.');
        }
        $('.id_groupe_delete').val(id);
        $('.window').css('display','block');
        $('.modal_confirm').css('display','block');
    }

    var modal = document.getElementById('myModal');
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            $('.window').css('display','none');
        }
    }
</script>
@if (!($errors->isEmpty()) || session('message'))
    <script type="text/javascript">
        setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
    </script>
@endif
@endsection
