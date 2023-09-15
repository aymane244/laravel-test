@extends('layouts.app')
@section('title') Rendez-vous @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@endsection


@section('content')

{{-- Message error et session --}}
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
{{-- Modal confirmation et update --}}
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

            <form id="destroy_event_form" action="{{ route('events.destroy',0) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
                <input type="hidden" class="id_evenement" name="id">
            </form>
            <form id="valider_event_form" action="{{ route('events.edit',0) }}" method="GET" class="d-none">
                @csrf
                <input type="hidden" class="id_evenement" name="id">
            </form>

        </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal" id="modal_event">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="exampleModalLabel">Modifier Rendez-vous</h5>
              <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">
                &times;
              </button>
            </div>
            <form method="POST" action="{{ route('events.update',0) }}">
                @csrf
                @method('PUT')

              <div class="modal-body">
                <div class="form-group">
                  <label for="title">Titre d'évènement</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="saisie d'évènement" required>
                </div>
                <div class="form-group">
                  <label for="start">Date debut</label>
                  <input type="datetime-local" class="form-control" name="start" id="start" required>
                </div>
                <div class="form-group">
                  <label for="end">Date fin</label>
                  <input type="datetime-local" class="form-control" name="end" id="end" required>
                  <small id="emailHelp" class="form-text text-muted">La date de fin doit être supérieure à la date de début !!!.</small>
                </div>
              </div>
              <div class="modal-footer border-top-0 d-flex justify-content-center">
                <input type="hidden" id="id_event" name="id">
                <input type="hidden" name="rendez_vous">
                <button type="submit" class="btn btn-primary">Modifier</button>
              </div>
            </form>
          </div>
        </div>
    </div>

{{-- Contenu --}}
    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Reception des rendez-vous</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>
            <div class="container-fluid mb-5 wow fadeIn" data-wow-duration="1.5s">
                <div class="main-body">

                            <div class="row">
                                <div class="col-lg-10 card p-4" style="margin: 0 auto;overflow-x: overlay">
                                    <table id="reception_rendez_vous" class="table table-bordered table-striped" style="width:100%">
                                        <thead style="background-color: #2d1166;color:white">
                                            <tr>
                                                <th>Logo</th>
                                                <th>Entreprise</th>
                                                <th>Email</th>
                                                <th>Numero Telephone</th>
                                                <th>Rendez-vous</th>
                                                <th>Date debut</th>
                                                <th>Date fin</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rendez_vous as $rdv)
                                                @if ($rdv->id_entreprise_rendez_vous==Auth::id())
                                                    <tr style="vertical-align: middle">
                                                        <td style="text-align: center">
                                                            @if ($rdv->User->logo==NULL)
                                                                @php
                                                                    $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                    $color = $colors[array_rand($colors)];
                                                                @endphp
                                                                <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                    <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($rdv->User->name, 0, 1); @endphp </h5>
                                                                </div>
                                                            @else
                                                                <img src="{{ asset('img/logos/'.$rdv->User->logo.'') }}" class="logo_rendez_vous" alt="{{ $rdv->User->name }}">
                                                            @endif

                                                        </td>
                                                        <td>{{ $rdv->User->name }}</td>
                                                        <td>{{ $rdv->User->email }}</td>
                                                        <td>{{ $rdv->User->tele }}</td>
                                                        <td>{{ $rdv->title }}</td>
                                                        <td>{{ $rdv->start }}</td>
                                                        <td>{{ $rdv->end }}</td>
                                                        <td>
                                                            <i style="margin-right: 10px;" class="fa fa-trash icon_action_event" onclick="confirmer('{{$rdv->id}}','destroy_event')" style="font-size: 25px"></i>
                                                            <i style="margin-right: 10px;" class="fa fa-check icon_action_event" onclick="confirmer('{{$rdv->id}}','valider_event')" style="font-size: 25px"></i>
                                                        </td>
                                                    </tr>
                                                @endif


                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            </div>
                        </div>

                        <div class="mt-5" style="text-align: center;margin-bottom: 45px">
                            <h1 style="font-weight: 900">Mes demandes des rendez-vous</h1>
                            <div class="h-divider-title">
                                <div class="shadow"></div>
                            </div>
                        </div>
                                <div class="container-fluid mb-5 wow fadeIn" data-wow-duration="1.5s">
                                    <div class="main-body">

                                                <div class="row">
                                                    <div class="col-lg-10 card p-4" style="margin: 0 auto;overflow-x: overlay">
                                                        <table id="demande_rendez_vous" class="table table-bordered table-striped" style="width:100%">
                                                            <thead style="background-color: #2d1166;color:white">
                                                                <tr>
                                                                    <th>Logo</th>
                                                                    <th>Entreprise</th>
                                                                    <th>Email</th>
                                                                    <th>Numero Telephone</th>
                                                                    <th>Rendez-vous</th>
                                                                    <th>Date debut</th>
                                                                    <th>Date fin</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($rendez_vous as $rdv)
                                                                    @if ($rdv->id_entreprise==Auth::id())
                                                                        <tr style="vertical-align: middle">
                                                                            <td style="text-align: center">
                                                                                @if ($rdv->user_rendez_vous->logo==NULL)
                                                                                    @php
                                                                                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                                        $color = $colors[array_rand($colors)];
                                                                                    @endphp
                                                                                    <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                                        <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($rdv->user_rendez_vous->name, 0, 1); @endphp </h5>
                                                                                    </div>
                                                                                @else
                                                                                    <img src="{{ asset('img/logos/'.$rdv->user_rendez_vous->logo.'') }}" class="logo_rendez_vous" alt="{{ $rdv->user_rendez_vous->name }}">
                                                                                @endif

                                                                            </td>
                                                                            <td>{{ $rdv->user_rendez_vous->name }}</td>
                                                                            <td>{{ $rdv->user_rendez_vous->email }}</td>
                                                                            <td>{{ $rdv->user_rendez_vous->tele }}</td>
                                                                            <td>{{ $rdv->title }}</td>
                                                                            <td>{{ $rdv->start }}</td>
                                                                            <td>{{ $rdv->end }}</td>
                                                                            <td>
                                                                                <i style="margin-right: 10px;" class="fa fa-trash icon_action_event" onclick="confirmer('{{$rdv->id}}','destroy_event')" style="font-size: 25px"></i>
                                                                                <i style="vertical-align: bottom;" data-toggle="modal" data-target="#form" class="fa fa-edit icon_action_event" onclick="edit_event('{{$rdv->id}}','{{$rdv->title}}','{{$rdv->start}}','{{$rdv->end}}')"></i></span>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

@endsection
@section('script')

    <script>
        function confirmer(id,traitement){
            if(traitement=='destroy_event'){
                $('#submit_confirmation').html('Delete');
                $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('destroy_event_form').submit();" );
                $("#icon_traitement" ).attr( "class", "fa fa-trash" );
                $('#p_confirmation').html('Voulez-vous vraiment supprimer cet rendez-vous? Ce processus ne peut pas être annulé. ');
            }
            else{
                $('#submit_confirmation').html('Valider');
                $("#icon_traitement" ).attr( "class", "fa fa-check" );
                $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('valider_event_form').submit();" );
                $('#p_confirmation').html('Voulez-vous vraiment valider cet rendez-vous? Ce processus ne peut pas être annulé.');
            }
            $('.id_evenement').val(id);
            $('.window').css('display','block');
            $('.modal_confirm').css('display','block');
        }

        function edit_event(id,title,start,end){
            $('#id_event').val(id);
            $('#title').val(title);
            $('#start').val(start);
            $('#end').val(end);
            $('.window').css('display','block');
            $('.modal').css('display','block');
        }

        var modal_event = document.getElementById('modal_event');
        var modal = document.getElementById('myModal');
        window.onclick = function(event) {
            if (event.target == modal_event || event.target == modal) {
                modal_event.style.display = "none";
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

    {{-- datatable --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reception_rendez_vous').DataTable({
                destroy: true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
            });
        });

        $(document).ready(function() {
            $('#demande_rendez_vous').DataTable({
                destroy: true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
            });
        });
    </script>
@endsection
