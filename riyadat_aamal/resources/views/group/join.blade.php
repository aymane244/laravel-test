@extends('layouts.ChatGroup')
@section('css')
<style>
    @media screen and (max-width: 1400px) and (min-width: 1200px){
     .rating-row {
     margin-left: -9px !important;
     margin-top: 17px;
     }
     .info_entreprise .logo_virtual{
        width: 81px !important;
    }
    }
    .card{
        height: 96% !important;
    }
    .div_admin_p{
        width: 100%;padding-left: 0px;margin-left: -4px;text-align: center;
    }
    .admin_p{
        background-color: #322d89;
    color: white;
    width: 113px;
    padding: 7px;
    border-radius: 0px 10px 10px 0px;
    }
 </style>
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/entreprises.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">

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

<div class="window" style="display: none"></div>
{{-- modal confirmation     --}}
<div id="myModal" class="modal_confirm modal">
    <div class="modal-dialog modal-confirm modal-dialog-centered mx-auto">
    <div class="modal-content">
        <div class="modal-header">
        <div class="icon-box">
            <i  id="icon_traitement" class="fa fa-check"></i>
        </div>
        <h4 class="modal-title">Êtes-vous sûr? </h4>
        <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">&times;</button>
        </div>
        <div class="modal-body">
        <p>Voulez-vous vraiment joindre dans cette groupe? Ce processus ne peut pas être annulé.</p>
        </div>

        <div class="modal-footer">
            <button class="btn btn-info" onclick="$('.window').css('display','none');$('.modal').css('display','none');">Cancel</button>
            <button class="btn btn-danger" onclick="event.preventDefault();document.getElementById('confirmer_jointure_groupe').submit();" id="submit_confirmation">Confirmer</button>
        </div>

        <form id="confirmer_jointure_groupe" action="/group/join" method="POST" class="d-none">
            @csrf
            <input type="hidden" id="id_groupe" name="code">
        </form>
    </div>
    </div>
</div>


<div class="mt-5" style="text-align: center;margin-bottom: 90px">
    <h1 style="font-weight: 900">Rejoindre des groupes</h1>
    <div class="h-divider-title">
        <div class="shadow"></div>
    </div>
</div>
<div class="container">
   <div class="row">

    @foreach($groupALL as $user)
        <div class="col-md-6 col-xl-3 col-lg-4">
            <div class="card m-b-30">
                <div class="card-body row" style="flex: none">
                    <div class="div_admin_p"><h5 class="admin_p">Admin</h5></div>
                    <div class="col-5 info_entreprise">
                        <a href="">
                            @if ($user->logo==NULL)
                                @php
                                    $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                    $color = $colors[array_rand($colors)];
                                @endphp
                                    <div class="logo_virtual" style="background-color: @php echo $color; @endphp;width:94px;height:94px">
                                        <h5 class="text-center" style="color: white;padding-top: 26px;font-size: xx-large;">@php echo substr($user->name, 0, 1); @endphp </h5>
                                    </div>
                            @else
                                <img src="{{ asset('img/logos/'.$user->logo.'') }}" alt="{{ $user->name }}" class="img-fluid rounded-circle" style="width: 94px;height: 94px;">
                            @endif
                        </a>
                    </div>
                    <div class="col-7 card-title pt-4 mb-0" style="padding-left: 0px;align-self: center">
                        <h5>{{ $user->name }}</h5>
                        <div class="rating-row">
                            <ul class="rating_entreprises">
                                <li class=""><i class="@if($user->rating >= 1 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                <li class=""><i class="@if($user->rating >= 2 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                <li class=""><i class="@if($user->rating >= 3 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                <li class=""><i class="@if($user->rating >= 4 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                <li class=""><i class="@if($user->rating >= 5 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fa fa-envelope" style="float: right"></i>Email : <br><a href="#">{{ $user->email }}</a></li>
                    <li class="list-group-item"><i class="fa fa-phone" style="float: right"></i>Phone : {{ $user->tele }}</li>
                    <li class="list-group-item"><i class="fa fa-phone" style="float: right"></i>Groupe : {{ $user->group_name }}</li>
                </ul>
                <div class="card-body">
                    <ul class="social-links list-inline mb-4 text-center">
                        <li class="list-inline-item"><a title="Facebook" class="tooltips" target="_blank" href="{{ $user->facebook }}" data-original-title="Facebook"><i style="margin-top: 10px" class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a title="Instagram" class="tooltips" target="_blank" href="{{ $user->instagram }}" data-original-title="Instagram"><i style="margin-top: 10px" class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a title="Website" class="tooltips" target="_blank" href="{{ $user->website }}" data-original-title="Globe"><i style="margin-top: 10px" class="fa fa-globe"></i></a></li>
                    </ul>
                    <div class="btn-group btn-group-sm div_entreprise_action" style="">
                        <a href="#" onclick="confirmer('{{$user->code}}')" class="btn btn-primary tooltips btn_action"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp Joindre</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
     </div>
</div>
@endsection
@section('script')

    <script>
        function confirmer(id){
            $('#id_groupe').val(id);
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
