@extends('dashboard.layout')
@section('title') Les Entreprises desactiver @endsection
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
                <i  id="icon_traitement" class="fa fa-user"></i>
            </div>
            <h4 class="modal-title" style="margin: 20px auto;">Êtes-vous sûr? </h4>
            <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">&times;</button>
            </div>
            <div class="modal-body">
            <p id="p_confirmation"></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-info" onclick="$('.window').css('display','none');$('.modal').css('display','none');">Cancel</button>
                <button class="btn btn-danger" id="submit_confirmation"></button>
            </div>

            <form id="destroy_entreprise_form" action="{{ route('dashboard.destroy',0) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
                <input type="hidden" class="id_entreprise" name="id">
            </form>

            <form id="valider_entreprise_form" action="{{ route('dashboard.edit',0) }}" method="GET" class="d-none">
                @csrf
                <input type="hidden" class="id_entreprise" name="id">
            </form>
        </div>
        </div>
    </div>


<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"> Dashboard Template </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Activer les Entreprises</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 wow fadeIn" data-wow-duration="1.5s">
                    <div class="card">
                        <h5 class="card-header">Activer les entreprises </h5>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="entreprise_desactiver" class="table table-bordered table-striped" style="width:100%">
                                    <thead style="background-color: #2d1166;color:white !important">
                                        <tr>
                                            <th>Nom d'entreprise</th>
                                            <th>Numero Telephone</th>
                                            <th>Adress</th>
                                            <th>Email</th>
                                            <th>Type Entreprise</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entreprises as $entreprise)
                                            <tr>
                                                <td>{{ $entreprise->name }}</td>
                                                <td>{{ $entreprise->tele }}</td>
                                                <td>{{ $entreprise->adress }}</td>
                                                <td>{{ $entreprise->email }}</td>
                                                <td>{{ $entreprise->type_entreprise }}</td>
                                                <td>
                                                    <i style="margin-right: 10px;" class="fa fa-trash icon_action_event" onclick="confirmer({{$entreprise->id}},'destroy_entreprise')" style="font-size: 25px"></i>
                                                    <i style="margin-right: 10px;" class="fa fa-check icon_action_event" onclick="confirmer({{$entreprise->id}},'valider_entreprise')" style="font-size: 25px"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    function confirmer(id,traitement){
        if(traitement=='destroy_entreprise'){
            $('#submit_confirmation').html('Delete');
            $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('destroy_entreprise_form').submit();" );
            $("#icon_traitement" ).attr( "class", "fa fa-trash" );
            $('#p_confirmation').html('Voulez-vous vraiment supprimer cette entreprise? Ce processus ne peut pas être annulé. ');
        }
        else{
            $('#submit_confirmation').html('Valider');
            $("#icon_traitement" ).attr( "class", "fa fa-check" );
            $("#submit_confirmation" ).attr( "onclick", "event.preventDefault();document.getElementById('valider_entreprise_form').submit();" );
            $('#p_confirmation').html('Voulez-vous vraiment valider cette entreprise? Ce processus ne peut pas être annulé.');
        }
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



    {{-- datatable --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#entreprise_desactiver').DataTable({
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
