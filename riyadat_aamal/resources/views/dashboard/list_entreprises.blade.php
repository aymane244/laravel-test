@extends('dashboard.layout')
@section('title') Les Entreprises @endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <style>th{color: white !important}</style>
@endsection

@section('content')


{{-- Message error et session --}}
@if (session('message'))
<div class="boucle_alerts">
    <div class="form-alerts toasts" style="position: static">
        <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">
            <div class="d-flex align-items-center">
                <i class="fa fa-cube" style="color: white;font-size: 30px"></i>
                <p><b class="d-flex">{{ session('message') }}.</b></p>
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

<div class="window" style="display: none;z-index: 1040"></div>
    {{-- modal confirmation  --}}
    <div id="myModal" class="modal_confirm modal">
        <div class="modal-dialog modal-confirm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <div class="icon-box">
                <i  id="icon_traitement" class="fa fa-trash"></i>
            </div>
            <h4 class="modal-title" style="margin: 20px auto;">Êtes-vous sûr? </h4>
            <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">&times;</button>
            </div>
            <div class="modal-body">
            <p id="p_confirmation">Voulez-vous vraiment supprimer cette entreprise? Ce processus ne peut pas être annulé.</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" onclick="$('.window').css('display','none');$('.modal').css('display','none');">Cancel</button>
                <button class="btn btn-danger" id="submit_confirmation" onclick="event.preventDefault();document.getElementById('destroy_entreprise_form').submit();">Supprimer</button>
            </div>

            <form id="destroy_entreprise_form" action="{{ route('dashboard.destroy',0) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
                <input type="hidden" class="id_entreprise" name="id">
            </form>
        </div>
        </div>
    </div>


<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"> Dashboard Template </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Liste des entreprises</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 wow fadeIn" data-wow-duration="1.5s">
                    <div class="card">
                        <h5 class="card-header">Les Entreprises </h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="list_entreprise" class="table table-bordered table-striped" style="width:100%">
                                    <thead style="background-color: #2d1166;color:white !important">
                                        <tr>
                                            <th>Logo</th>
                                            <th>Nom d'entreprise</th>
                                            <th>Numero Telephone</th>
                                            <th>Adress</th>
                                            <th>Email</th>
                                            <th>Num rc</th>
                                            <th>Num if</th>
                                            <th>cnss</th>
                                            <th>ice</th>
                                            <th>Type Entreprise</th>
                                            <th style="width: 112px">Social Media</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entreprises as $entreprise)
                                            <tr>
                                                <td>
                                                    @if ($entreprise->logo==NULL)
                                                        @php
                                                            $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                            $color = $colors[array_rand($colors)];
                                                        @endphp
                                                        <div class="logo_rendez_vous" style="background-color: @php echo $color; @endphp;height:100px;width:100px">
                                                            <h5 class="text-center text-white" style="padding-top: 35px;font-size: xx-large;">@php echo substr($entreprise->name, 0, 1); @endphp </h5>
                                                        </div>
                                                    @else
                                                    <a href="{{ asset('img/logos/'.$entreprise->logo.'') }}" target="_blank">
                                                        <img src="{{ asset('img/logos/'.$entreprise->logo.'') }}" class="logo_rendez_vous" style="width: 100px;height: 100px;" alt="{{ $entreprise->name }}">
                                                    </a>

                                                    @endif
                                                </td>
                                                <td>{{ $entreprise->name }}</td>
                                                <td>{{ $entreprise->tele }}</td>
                                                <td>{{ $entreprise->adress }}</td>
                                                <td>{{ $entreprise->email }}</td>
                                                <td>{{ $entreprise->num_rc }}</td>
                                                <td>{{ $entreprise->ide_fiscal }}</td>
                                                <td>{{ $entreprise->num_cnss }}</td>
                                                <td>{{ $entreprise->num_ice }}</td>
                                                <td>{{ $entreprise->type_entreprise }}</td>
                                                <td style="width: 112px">
                                                    <a href="{{ $entreprise->facebook }}" target="_blank"><i style="margin-right: 10px;font-size: 18px" class="fa fa-facebook icon_action_event"></i></a>
                                                    <a href="{{ $entreprise->instagram }}" target="_blank"><i style="margin-right: 10px;font-size: 18px" class="fa fa-instagram icon_action_event"></i></a>
                                                    <a href="{{ $entreprise->website }}" target="_blank"><i style="margin-right: 10px;font-size: 18px" class="fa fa-globe icon_action_event"></i></a>
                                                </td>
                                                <td><i style="margin-right: 10px;" class="fa fa-trash icon_action_event" onclick="confirmer({{$entreprise->id}})" style="font-size: 25px"></i></td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                {{ $entreprises->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function confirmer(id){
        $('.id_entreprise').val(id);
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#list_entreprise').DataTable({
                destroy: true,
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": true,
            });
        });
    </script>
@endsection
