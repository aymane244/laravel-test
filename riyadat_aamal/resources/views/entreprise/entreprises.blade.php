@extends('layouts.app')
@section('title') Entreprises @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/entreprises.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">
    <style>
        .card{
        height: 96% !important;
    }
    @media (max-width: 1400px) and (min-width: 1200px) {
        .info_entreprise .logo_virtual{
            width: 102px !important;
        }
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

    <div class="window" style="display: none"></div>
    {{-- Modal --}}
     <div class="modal" id="modal_event">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="exampleModalLabel">Créer un rendez-vous</h5>
              <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">
                &times;
              </button>
            </div>
            <form method="POST" action="{{ route('events.store') }}">
            @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="title">Titre d'évènement</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="saisie d'évènement" required>
                </div>
                <div class="form-group">
                  <label for="start">Date debut</label>
                  <input type="datetime-local" class="form-control" name="start" id="start" placeholder="saisie date debut" required>
                </div>
                <div class="form-group">
                  <label for="end">Date fin</label>
                  <input type="datetime-local" class="form-control" name="end" id="end" placeholder="saisie date fin" required>
                  <small id="emailHelp" class="form-text text-muted">La date de fin doit être supérieure à la date de début !!!.</small>
                </div>
              </div>
              <div class="modal-footer border-top-0 d-flex justify-content-center">
                <input type="hidden" id="id_entreprise_rendez_vous" name="id_entreprise_rendez_vous">
                <button type="submit" class="btn btn-primary">Créer</button>
              </div>
            </form>
          </div>
        </div>
    </div>

{{-- Contenu --}}
    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Entreprises</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>

    <div class="container mb-5 wow fadeIn" data-wow-duration="1.5s">
        <div class="row">

            @foreach ($entreprises as $entreprise)
                @if ($entreprise->id != Auth::id())
                    <div class="col-md-6 col-xl-3 col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body row" style="">
                                <div class="col-6 info_entreprise">
                                    <a href="">
                                        @if ($entreprise->logo==NULL)
                                            @php
                                                $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                $color = $colors[array_rand($colors)];
                                            @endphp
                                                <div class="logo_virtual" style="background-color: @php echo $color; @endphp;width:120px;height:120px">
                                                    <h5 class="text-center" style="color: white;padding-top: 26px;font-size: xxx-large;">@php echo substr($entreprise->name, 0, 1); @endphp </h5>
                                                </div>
                                        @else
                                            <img src="{{ asset('img/logos/'.$entreprise->logo.'') }}" alt="{{ $entreprise->name }}" class="img-fluid rounded-circle" style="width: 120px;height: 120px;">
                                        @endif

                                    </a>
                                </div>
                                <div class="col-6 card-title pt-4 mb-0" style="padding-left: 0px;align-self: center">
                                    <h5>{{ $entreprise->name }}</h5>
                                    <p class="m-0" style="color: #707070">{{ $entreprise->type_entreprise }}</p>
                                </div>

                            </div>
                            <div class="rating-row mb-3" style="align-self: center">
                                <ul class="rating_entreprises">
                                    <li class=""><i class="@if($entreprise->rating >= 1 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                    <li class=""><i class="@if($entreprise->rating >= 2 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                    <li class=""><i class="@if($entreprise->rating >= 3 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                    <li class=""><i class="@if($entreprise->rating >= 4 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                    <li class=""><i class="@if($entreprise->rating >= 5 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                </ul>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fa fa-envelope" style="float: right"></i>Email : <br><a href="#">{{ $entreprise->email }}</a></li>
                                <li class="list-group-item"><i class="fa fa-phone" style="float: right"></i>Phone : {{ $entreprise->tele }}</li>
                                <li class="list-group-item" style="height: 117px;overflow-y: overlay"><i class="fa fa-map-marker" style="float: right;font-size: 20px"></i>Location : {{ $entreprise->adress }}</li>
                            </ul>
                            <div class="card-body">
                                <ul class="social-links list-inline mb-4 text-center">
                                    <li class="list-inline-item"><a title="Facebook" class="tooltips" target="_blank" href="{{ $entreprise->facebook }}" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                    <li class="list-inline-item"><a title="Instagram" class="tooltips" target="_blank" href="{{ $entreprise->instagram }}" data-original-title="Instagram"><i class="fa fa-instagram"></i></a></li>
                                    <li class="list-inline-item"><a title="Website" class="tooltips" target="_blank" href="{{ $entreprise->website }}" data-original-title="Globe"><i class="fa fa-globe"></i></a></li>
                                </ul>
                                <div class="btn-group btn-group-sm div_entreprise_action" style="">
                                    <a href="#" onclick="add_rendez_vous('{{$entreprise->id}}')" class="btn btn-primary tooltips btn_action"><i class="fa fa-calendar"></i> Rendez-vous</a>
                                    <a href="{{ route('recommandation.show',$entreprise->id) }}" class="btn btn-primary tooltips btn_action"><i class="fa fa-pencil"></i> Recommandation</a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div style="margin: 0 auto;width:20%">{{ $entreprises->links() }}</div>
    </div>

@endsection
@section('script')

    <script>
        function add_rendez_vous(id){
            $('#id_entreprise_rendez_vous').val(id);
            $('.window').css('display','block');
            $('.modal').css('display','block');
        }
        var modal = document.getElementById('modal_event');
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
