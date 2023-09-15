@extends('layouts.app')
@section('title') Mes Recommandations @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
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

            <form id="destroy_recommandation_form" action="{{ route('recommandation.destroy',0) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
                <input type="hidden" class="id_recommandation" name="id">
            </form>

            <form id="valider_recommandation_form" action="{{ route('recommandation.edit',0) }}" method="GET" class="d-none">
                @csrf
                <input type="hidden" class="id_recommandation" name="id">
            </form>

        </div>
        </div>
    </div>
    {{-- modal Comments --}}
    <div class="modal modal_recommandation" id="modal_recom">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="exampleModalLabel">Comment && rating de recommandation</h5>
              <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">
                &times;
              </button>
            </div>
            <form method="POST" action="{{ route('recommandation.update',0) }}">
                @csrf
                @method('PUT')

              <div class="modal-body">

                <div class="form-group mt-3">
                  <label for="">Rating</label>
                    <div class="star-rating" style="border: none;font-size: 37px">
                        <input type="radio" id="5-stars" name="rating" value="5" />
                        <label for="5-stars" class="star">&#9733;</label>
                        <input type="radio" id="4-stars" name="rating" value="4" />
                        <label for="4-stars" class="star">&#9733;</label>
                        <input type="radio" id="3-stars" name="rating" value="3" />
                        <label for="3-stars" class="star">&#9733;</label>
                        <input type="radio" id="2-stars" name="rating" value="2" />
                        <label for="2-stars" class="star">&#9733;</label>
                        <input type="radio" id="1-star" name="rating" value="1" />
                        <label for="1-star" class="star">&#9733;</label>
                    </div>
                    <small id="helpId" class="text-muted">Rating de Projet et services d'entreprise</small>
                </div>
                <div class="form-group mt-3 pt-4">
                    <label for="">Comment</label>
                    <div class="mt-3" style="">

                        <div class="body_comment">
                            <div class="row">
                                <div class="col-2">
                                    <div class="avatar_comment col-md-1">
                                        @if (auth()->user()->logo==NULL)
                                            @php
                                            $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                            $color = $colors[array_rand($colors)];
                                            @endphp
                                            <div class="logo_virtual" style="background-color: @php echo $color; @endphp;width:66px;height:66px">
                                                <h5 class="text-center" style="color: white;padding-top: 18px">@php echo substr(auth()->user()->name, 0, 1); @endphp </h5>
                                            </div>
                                        @else
                                            <img src="{{ asset('img/logos/'.Auth::user()->logo.'') }}" class="avatar logo_entreprise_commenter" alt="{{ auth()->user()->name }}">
                                        @endif
                                      </div>
                                </div>
                                <div class="col-10">
                                    <div class="box_comment col-md-11">
                                        <textarea class="commentar" name="comment" placeholder="Ajouter un commentaire ..."></textarea>
                                        <div class="box_post">

                                          <div class="pull-right">
                                            <input type="hidden" id="id_recom" name="id_recom">
                                            <button type="submit">Post</button>
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
        </div>
    </div>


    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Traitement des recommandations</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>
            <div class="container-fluid mb-5 wow fadeIn" data-wow-duration="1.5s">
                <div class="main-body">

                            <div class="row">
                                <div class="col-lg-10 card p-4" style="margin: 0 auto;overflow-x: overlay">
                                    <table id="traitement_recommandation" class="table table-bordered table-striped" style="width:100%">
                                        <thead style="background-color: #2d1166;color:white">
                                            <tr>
                                                <th>Logo</th>
                                                <th>Entreprise</th>
                                                <th>Email</th>
                                                <th>Numero Telephone</th>
                                                <th>Recommandation</th>
                                                <th>Date de recommandation</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recommandations as $recommandation)
                                                @if ($recommandation->id_entreprise_recom==Auth::id() && $recommandation->etat_recom=='en attente')
                                                    <tr style="vertical-align: middle">
                                                        <td style="text-align: center">
                                                            @if ($recommandation->User->logo==NULL)
                                                                @php
                                                                    $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                    $color = $colors[array_rand($colors)];
                                                                @endphp
                                                                <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                    <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($recommandation->User->name, 0, 1); @endphp </h5>
                                                                </div>
                                                            @else
                                                                <img src="{{ asset('img/logos/'.$recommandation->User->logo.'') }}" class="logo_rendez_vous" alt="{{ $recommandation->User->name }}">
                                                            @endif

                                                        </td>
                                                        <td>{{ $recommandation->User->name }}</td>
                                                        <td>{{ $recommandation->User->email }}</td>
                                                        <td>{{ $recommandation->User->tele }}</td>
                                                        <td>{{ $recommandation->title }}</td>
                                                        <td>{{ $recommandation->date_recom }}</td>
                                                        <td>
                                                            <i style="margin-right: 10px;" class="fa fa-trash icon_action_event" onclick="confirmer({{$recommandation->id}},'destroy_recommandation')" style="font-size: 25px"></i>
                                                            <i style="margin-right: 10px;" class="fa fa-check icon_action_event" onclick="confirmer({{$recommandation->id}},'valider_recommandation')" style="font-size: 25px"></i>
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
                            <h1 style="font-weight: 900">Des recommandations en attente</h1>
                            <div class="h-divider-title">
                                <div class="shadow"></div>
                            </div>
                        </div>
                                <div class="container-fluid mb-5 wow fadeIn" data-wow-duration="1.5s">
                                    <div class="main-body">

                                                <div class="row">
                                                    <div class="col-lg-10 card p-4" style="margin: 0 auto;overflow-x: overlay">
                                                        <table id="recommandation_en_attente" class="table table-bordered table-striped" style="width:100%">
                                                            <thead style="background-color: #2d1166;color:white">
                                                                <tr>
                                                                    <th>Logo</th>
                                                                    <th>Entreprise</th>
                                                                    <th>Email</th>
                                                                    <th>Numero Telephone</th>
                                                                    <th>Recommandation</th>
                                                                    <th>Date de recommandation</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($recommandations as $recommandation)
                                                                    @if ($recommandation->id_entreprise==Auth::id() && $recommandation->etat_recom=='en attente')
                                                                        <tr style="vertical-align: middle">
                                                                            <td style="text-align: center">
                                                                                @if ($recommandation->user_recom->logo==NULL)
                                                                                    @php
                                                                                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                                        $color = $colors[array_rand($colors)];
                                                                                    @endphp
                                                                                    <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                                        <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($recommandation->user_recom->name, 0, 1); @endphp </h5>
                                                                                    </div>
                                                                                @else
                                                                                    <img src="{{ asset('img/logos/'.$recommandation->user_recom->logo.'') }}" class="logo_rendez_vous" alt="{{ $recommandation->user_recom->name }}">
                                                                                @endif

                                                                            </td>
                                                                            <td>{{ $recommandation->user_recom->name }}</td>
                                                                            <td>{{ $recommandation->user_recom->email }}</td>
                                                                            <td>{{ $recommandation->user_recom->tele }}</td>
                                                                            <td>{{ $recommandation->title }}</td>
                                                                            <td>{{ $recommandation->date_recom }}</td>
                                                                            <td>
                                                                                <div class="load">
                                                                                    <div class="load-one"></div>
                                                                                    <div class="load-two"></div>
                                                                                    <div class="load-three"></div>
                                                                                </div>
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
        <h1 style="font-weight: 900">Mes recommandations</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>
            <div class="container-fluid mb-5 wow fadeIn" data-wow-duration="1.5s">
                <div class="main-body">

                            <div class="row">
                                <div class="col-lg-10 card p-4" style="margin: 0 auto;overflow-x: overlay">
                                    <table id="mes_recommandation" class="table table-bordered table-striped" style="width:100%">
                                        <thead style="background-color: #2d1166;color:white">
                                            <tr>
                                                <th>Logo</th>
                                                <th>Etat</th>
                                                <th>Entreprise</th>
                                                <th>Email</th>
                                                <th>Numero Telephone</th>
                                                <th>Recommandation</th>
                                                <th>Date de recommandation</th>
                                                <th>Comment</th>
                                                <th>Rating</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recommandations as $recommandation)
                                                @if ($recommandation->etat_recom=='valider' || $recommandation->etat_recom=='valider-commenter')
                                                    <tr style="vertical-align: middle">
                                                        @if ($recommandation->id_entreprise==Auth::id())
                                                            <td style="text-align: center">
                                                                @if ($recommandation->user_recom->logo==NULL)
                                                                    @php
                                                                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                        $color = $colors[array_rand($colors)];
                                                                    @endphp
                                                                    <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                        <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($recommandation->user_recom->name, 0, 1); @endphp </h5>
                                                                    </div>
                                                                @else
                                                                    <img src="{{ asset('img/logos/'.$recommandation->user_recom->logo.'') }}" class="logo_rendez_vous" alt="{{ $recommandation->user_recom->name }}">
                                                                @endif

                                                            </td>
                                                            <td class="etat_event"><i class="fa fa-paper-plane" aria-hidden="true"></i></td>
                                                            <td>{{ $recommandation->user_recom->name }}</td>
                                                            <td>{{ $recommandation->user_recom->email }}</td>
                                                            <td>{{ $recommandation->user_recom->tele }}</td>
                                                        @else
                                                            <td style="text-align: center">
                                                                @if ($recommandation->user->logo==NULL)
                                                                    @php
                                                                        $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                                        $color = $colors[array_rand($colors)];
                                                                    @endphp
                                                                    <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp">
                                                                        <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 35px">@php echo substr($recommandation->user->name, 0, 1); @endphp </h5>
                                                                    </div>
                                                                @else
                                                                    <img src="{{ asset('img/logos/'.$recommandation->user->logo.'') }}" class="logo_rendez_vous" alt="{{ $recommandation->user->name }}">
                                                                @endif

                                                            </td>
                                                            <td class="etat_event"><i class="fa fa-sign-in" aria-hidden="true" style="font-size: 23px"></i></td>
                                                            <td>{{ $recommandation->user->name }}</td>
                                                            <td>{{ $recommandation->user->email }}</td>
                                                            <td>{{ $recommandation->user->tele }}</td>
                                                        @endif

                                                        <td>{{ $recommandation->title }}</td>
                                                        <td>{{ $recommandation->date_recom }}</td>

                                                        @if ($recommandation->etat_recom=='valider-commenter')
                                                            <td>{{ $recommandation->comment }}</td>
                                                            <td>
                                                                <div class="rating-row">
                                                                    <ul>
                                                                        <li class=""><i class="@if($recommandation->rating >= 1 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                        <li class=""><i class="@if($recommandation->rating >= 2 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                        <li class=""><i class="@if($recommandation->rating >= 3 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                        <li class=""><i class="@if($recommandation->rating >= 4 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                        <li class=""><i class="@if($recommandation->rating >= 5 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                            <td class="etat_event""><span>Commenter</span></td>
                                                        @else
                                                            <td class="etat_event"><span>X</span></td>
                                                            <td class="etat_event"><span>X</span></td>
                                                            @if ($recommandation->id_entreprise==Auth::id())
                                                                <td style="text-align: center"><i onclick="commenter({{ $recommandation->id }})" class="fa fa-commenting icon_action_event" aria-hidden="true"></i></td>
                                                            @else
                                                                <td class="etat_event""><span>en attente de commentaire </span></td>
                                                            @endif
                                                        @endif
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
            if(traitement=='destroy_recommandation'){
                $('#submit_confirmation').html('Delete');
                $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('destroy_recommandation_form').submit();" );
                $("#icon_traitement" ).attr( "class", "fa fa-trash" );
                $('#p_confirmation').html('Voulez-vous vraiment supprimer cet recommandation? Ce processus ne peut pas être annulé. ');
            }
            else{
                $('#submit_confirmation').html('Valider');
                $("#icon_traitement" ).attr( "class", "fa fa-check" );
                $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('valider_recommandation_form').submit();" );
                $('#p_confirmation').html('Voulez-vous vraiment valider cet recommandation? Ce processus ne peut pas être annulé.');
            }
            $('.id_recommandation').val(id);
            $('.window').css('display','block');
            $('.modal_confirm').css('display','block');
        }

        function commenter(id){
            $("#id_recom").val(id);
            $('.window').css('display','block');
            $('.modal_recommandation').css('display','block');
        }

        var modal_recom = document.getElementById('modal_recom');
        var modal = document.getElementById('myModal');
        window.onclick = function(event) {
            if (event.target == modal_recom || event.target == modal) {
                modal_recom.style.display = "none";
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
            $('#traitement_recommandation').DataTable({
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
            $('#mes_recommandation').DataTable({
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
            $('#recommandation_en_attente').DataTable({
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
