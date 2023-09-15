@extends('layouts.app')
@section('title') Events @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
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
    {{-- modal confirmation     --}}
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
            <p>Voulez-vous vraiment supprimer cet évènement? Ce processus ne peut pas être annulé.</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" onclick="$('.window').css('display','none');$('.modal').css('display','none');">Cancel</button>
                <button class="btn btn-danger" onclick="event.preventDefault();document.getElementById('destroy_event_form').submit();" id="submit_confirmation">Supprimer</button>
            </div>

            <form id="destroy_event_form" action="{{ route('events.destroy',0) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
                <input type="hidden" id="id_evenement_delete" name="id">
            </form>
        </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal" id="modal_event">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="exampleModalLabel">Modifier évènement</h5>
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
                <input type="hidden" name="event">
                <button type="submit" class="btn btn-primary">Modifier</button>
              </div>
            </form>
          </div>
        </div>
    </div>

{{-- Contenu --}}
    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Mes Events et Rendez-vous</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>

   <div class="container-fluid mb-5 wow fadeIn" data-wow-duration="1.5s">
        <div class="main-body">

                    <div class="row">
                        <div class="col-lg-12 card p-4 mb-5" style="margin: 0 auto;overflow-x: overlay">
                            <table id="data_events" class="table table-bordered table-striped" style="width:100%">
                                <thead style="background-color: #2d1166;color:white">
                                    <tr>
                                        <th>Logo</th>
                                        <th>Entreprise</th>
                                        <th>Email</th>
                                        <th>Numero Telephone</th>
                                        <th>Rendez-vous / évènement</th>
                                        <th>Date debut</th>
                                        <th>Date fin</th>
                                        <th>Actions</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr style="vertical-align: middle">

                                            {{-- randez vous --}}
                                            @if ($event->etat_rendez_vous=='valider')

                                                {{-- auth est demande --}}
                                                @if ($event->id_entreprise==Auth::id())
                                                    <td style="text-align: center">
                                                        @if ($event->user_rendez_vous->logo==NULL)
                                                            @php
                                                                $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                $color = $colors[array_rand($colors)];
                                                            @endphp
                                                            <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($event->user_rendez_vous->name, 0, 1); @endphp </h5>
                                                            </div>
                                                        @else
                                                            <img src="{{ asset('img/logos/'.$event->user_rendez_vous->logo.'') }}" class="logo_rendez_vous" alt="{{ $event->user_rendez_vous->name }}">
                                                        @endif

                                                    </td>
                                                    <td>{{ $event->user_rendez_vous->name }}</td>
                                                    <td>{{ $event->user_rendez_vous->email }}</td>
                                                    <td>{{ $event->user_rendez_vous->tele }}</td>
                                                @else
                                                    {{-- Auth est recepteur --}}
                                                    <td style="text-align: center">
                                                        @if ($event->user->logo==NULL)
                                                            @php
                                                                $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                $color = $colors[array_rand($colors)];
                                                            @endphp
                                                            <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($event->user->name, 0, 1); @endphp </h5>
                                                            </div>
                                                        @else
                                                            <img src="{{ asset('img/logos/'.$event->user->logo.'') }}" class="logo_rendez_vous" alt="{{ $event->user->name }}">
                                                        @endif

                                                    </td>
                                                    <td>{{ $event->user->name }}</td>
                                                    <td>{{ $event->user->email }}</td>
                                                    <td>{{ $event->user->tele }}</td>
                                                @endif

                                            @else
                                            {{-- evenement --}}
                                                <td class="etat_event"><span>X</span></td>
                                                <td class="etat_event"><span>X</span></td>
                                                <td class="etat_event"><span>X</span></td>
                                                <td class="etat_event"><span>X</span></td>
                                            @endif

                                            <td>{{ $event->title }}</td>
                                            <td>{{ $event->start }}</td>
                                            <td>{{ $event->end }}</td>
                                            <td>
                                                <i style="margin-right: 10px;" class="fa fa-trash icon_action_event" onclick="confirmer('{{$event->id}}')" style="font-size: 25px"></i>
                                                <i style="vertical-align: bottom;" data-toggle="modal" data-target="#form" class="fa fa-edit icon_action_event" onclick="edit_event('{{$event->id}}','{{$event->title}}','{{$event->start}}','{{$event->end}}')"></i></span>
                                            </td>
                                            <td class="etat_event"">
                                                <span>
                                                    @if ($event->etat_rendez_vous=='valider')
                                                        Randez-vous
                                                    @else
                                                        Evènement
                                                    @endif
                                                </span>

                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="paginate_event">{{ $events->links() }}</div>
                        </div>
                         <div class="col-lg-5 wow fadeIn" data-wow-duration="1.5s" style="margin: 0 auto">
                                <form method="POST" action="{{ route('events.store') }}" >
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="d-flex align-items-center mb-5">Creation d'évènement</h5>
                                            <div class="row mb-4">
                                                <div class="col-sm-3 mt-2">
                                                    <h6 class="mb-0">Titre d'évènement</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-etsy" aria-hidden="true"></i>                                            </span>
                                                        <input type="text" name="title" @error('title') is-invalid @enderror class="form-control" placeholder="Enter titre d'évènement" aria-label="title" required aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-sm-3 mt-2">
                                                    <h6 class="mb-0">Date debut</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                        <input type="datetime-local" name="start" @error('start') is-invalid @enderror class="form-control" placeholder="Enter date debut" aria-label="start" required aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-sm-3 mt-2">
                                                    <h6 class="mb-0">Date fin</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                        <input type="datetime-local" name="end" @error('end') is-invalid @enderror class="form-control" placeholder="Name") aria-label="end" required aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9 text-secondary" style="text-align: right">
                                                    <input type="submit" class="btn btn-primary px-4" style="width: 150px" value="Edit">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection
@section('script')

    <script>
        function confirmer(id){
            $('#id_evenement_delete').val(id);
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
            $('#data_events').DataTable({
                destroy: true,
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
            });
        });

        $(document).ready(function() {
            $('#data_rendez_vous').DataTable({
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
