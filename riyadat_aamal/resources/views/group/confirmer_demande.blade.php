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
{{-- modal confirmation  --}}
<div id="myModal" class="modal_confirm modal">
    <div class="modal-dialog modal-confirm modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-header">
            <div class="icon-box">
                <i  id="icon_traitement" class="fa fa-user"></i>
            </div>
            <h4 class="modal-title">Êtes-vous sûr? </h4>
            <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">&times;</button>
            </div>
            <div class="modal-body">
            <p id="p_confirmation"></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" onclick="$('.window').css('display','none');$('.modal').css('display','none');">Cancel</button>
                <button class="btn btn-danger" id="submit_confirmation"></button>
            </div>

            <form id="destroy_jointure_form" action="/join/delete" method="POST" class="d-none">
                @csrf
                <input type="hidden" class="id_user" name="id_user">
                <input type="hidden" class="id_group" name="id_group">
            </form>
            <form id="valider_jointure_form" action="/join/valider" method="POST" class="d-none">
                @csrf
                <input type="hidden" class="id_user" name="id_user">
                <input type="hidden" class="id_group" name="id_group">
            </form>
        </div>
    </div>
</div>

<div class="mt-5" style="text-align: center;margin-bottom: 90px">
    <h1 style="font-weight: 900">Les demandes de jointure des groupes</h1>
    <div class="h-divider-title">
        <div class="shadow"></div>
    </div>
</div>

<div class="container">
   <div class="row">

        @foreach($Users as $user)
            <div class="col-md-6 col-xl-3 col-lg-4">
                <div class="card m-b-30">
                    <div class="card-body row" style="flex: none">
                        <div class="col-5 info_entreprise">
                            <a href="">
                                @if ($user->logo==NULL)
                                    @php
                                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                        $color = $colors[array_rand($colors)];
                                    @endphp
                                        <div class="logo_virtual" style="background-color: @php echo $color; @endphp;width:100px;height:95px;object-fit: cover;">
                                            <h5 class="text-center" style="color: white;padding-top: 26px;font-size: xx-large;">@php echo substr($user->name, 0, 1); @endphp </h5>
                                        </div>
                                @else
                                    <img src="{{ asset('img/logos/'.$user->logo.'') }}" alt="{{ $user->name }}" class="img-fluid rounded-circle" style="width: 120px;height: 95px;">
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
                            <li class="list-inline-item"><a title="Website" class="tooltips" target="_blank" href="{{ $user->website }}" data-original-title="Globe"><i style="margin-top: 10px" class="fa fa-users" aria-hidden="true"></i></a></li>
                        </ul>
                        <div class="btn-group btn-group-sm div_entreprise_action" style="">
                            <a href="#" onclick="confirmer_delete_jointure('{{$user->id}}','{{ $user->group_id }}','valider_jointure')" class="btn btn-primary tooltips btn_action"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp Valider</a>
                            <a href="#" onclick="confirmer_delete_jointure('{{$user->id}}','{{ $user->group_id }}','delete_jointure')" class="btn btn-primary tooltips btn_action"><i class="fa fa-trash"></i>&nbsp Supprimer</a>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
     <div style="margin: 0 auto;width:20%">{{ $Users->links() }}</div>
</div>
@endsection
@section('script')
<script>
    function confirmer_delete_jointure(id,id_groupe,traitement){
        if(traitement=='delete_jointure'){
            $('#submit_confirmation').html('Delete');
            $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('destroy_jointure_form').submit();" );
            $("#icon_traitement" ).attr( "class", "fa fa-trash" );
            $('#p_confirmation').html('Voulez-vous vraiment supprimer cet demande de jointure? Ce processus ne peut pas être annulé. ');
        }
        else{
            $('#submit_confirmation').html('Valider');
            $("#icon_traitement" ).attr( "class", "fa fa-check" );
            $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('valider_jointure_form').submit();" );
            $('#p_confirmation').html('Voulez-vous vraiment valider cet demande de jointure? Ce processus ne peut pas être annulé.');
        }
        $('.id_user').val(id);
        $('.id_group').val(id_groupe);
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
