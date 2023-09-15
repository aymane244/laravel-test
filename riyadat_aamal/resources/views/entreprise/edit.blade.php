@extends('layouts.app')
@section('title') Profile @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

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

    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Edit</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>
<div class="container-fluid">
    <div class="main-body">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">BrandName</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0)">{{{ Auth::user()->name }}}</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('entreprises.show','Profile') }}">Profile</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
            <form method="POST" action="{{ route('entreprises.update',0) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center mb-5">Logo</h5>

                            <div class="d-flex flex-column align-items-center text-center">


                                <div class="container_logo">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="logo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            @if (auth()->user()->logo==NULL)
                                                @php
                                                    $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                    $color = $colors[array_rand($colors)];
                                                @endphp
                                                <div id="imagePreview" style="background-color: @php echo $color; @endphp">
                                                    <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 71px">@php echo substr(auth()->user()->name, 0, 1); @endphp </h5>
                                                </div>
                                            @else
                                                <div id="imagePreview" style="background-image: url('{{ asset('img/logos/'.Auth::user()->logo.'') }}');"></div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <hr class="my-4">
                            <h5 class="d-flex align-items-center mb-4">Social media</h5>
                            <ul class="list-group list-group-flush">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex  align-items-center flex-wrap mb-1 pb-3">

                                    <div class="row_input">
                                        <span>
                                        <input class="slide-up" id="card" type="text" name="website" placeholder="Your website" value="{{ auth()->user()->website }}"/><label for="card"> <i class="fa fa-globe"></i>  Website</label>
                                        </span>
                                    </div>

                                    </li>
                                    <li class="list-group-item d-flex  align-items-center flex-wrap mb-1 pb-3">
                                    <div class="row_input">
                                        <span>
                                        <input class="slide-up" id="card" type="text" name="facebook" placeholder="Your facebook" value="{{ auth()->user()->facebook }}"/><label for="card"> <i class="fa fa-facebook"></i>  facebook</label>
                                        </span>
                                    </div>
                                    </li>
                                    <li class="list-group-item d-flex  align-items-center flex-wrap mb-1 pb-3">
                                    <div class="row_input">
                                        <span>
                                        <input class="slide-up" id="card" type="text" name="instagram" placeholder="Your instagram" value="{{ auth()->user()->instagram }}"/><label for="card"> <i class="fa fa-instagram"></i>  instagram</label>
                                        </span>
                                    </div>
                                    </li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center mb-5">Entreprise informations</h5>
                            <div class="row mb-4">
                                <div class="col-sm-3 mt-2">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                        <input type="text" name="name" @error('name') is-invalid @enderror class="form-control" placeholder="Name" value="{{ auth()->user()->name }}" aria-label="Username" required aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3 mt-2">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                        <input type="text" class="form-control" name="email" placeholder="Email" value="{{ auth()->user()->email }}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3 mt-2">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="tele" placeholder="Phone" value="{{ auth()->user()->tele }}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3 mt-2">
                                    <h6 class="mb-0">Type</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    @php
                                        $type_entreprise=['Auto entrepreneur','Sarl','Société anonyme'];
                                    @endphp
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i></span>
                                        <select class="form-select" id="select_type" @error('type_entreprise') is-invalid @enderror aria-label="Default select example" name="type_entreprise" value="{{ auth()->user()->type_entreprise }}" required>
                                            @foreach ($type_entreprise as $type)
                                                <option value="{{ $type }}" @php if (auth()->user()->type_entreprise == $type) echo 'selected'; @endphp>{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Le Registre de Commerce (RC)</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-registered"></i></span>
                                        <input type="text" class="form-control" name="num_rc" id="input_rc" placeholder="Numero RC" value="{{ auth()->user()->num_rc }}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">L’Identifiant Fiscal et la patente (IF)</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-info-circle"></i></span>
                                        <input type="text" class="form-control" name="ide_fiscal" id="input_if" placeholder="Numero IF" value="{{ auth()->user()->ide_fiscal }}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Numéro d’affiliation à la CNSS</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-copyright"></i></span>
                                        <input type="text" class="form-control" name="num_cnss" id="input_cnss" placeholder="Numero CNSS" value="{{ auth()->user()->num_cnss }}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Identifiant Commun de l’Entreprise (ICE)</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-id-card-o"></i></span>
                                        <input type="text" class="form-control" name="num_ice" id="input_ice" placeholder="Numero ICE" value="{{ auth()->user()->num_ice }}" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-3 mt-2">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"></i></span>
                                        <input type="text" class="form-control" name="adress" placeholder="Address" value="{{ auth()->user()->adress }}" aria-label="Username" aria-describedby="basic-addon1">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        $( "#select_type" ).change(function () {
            $( "#select_type option:selected" ).each(function() {
            if($( this ).text()=='Auto entrepreneur'){
                $('#input_rc').attr('disabled','disabled');
                $('#input_rc').val(null);
                $('#input_if').attr('disabled','disabled');
                $('#input_if').val(null);
                $('#input_cnss').attr('disabled','disabled');
                $('#input_cnss').val(null);
            }
            else{
                $('#input_rc').removeAttr('disabled');
                $('#input_rc').val({{ auth()->user()->num_rc }});
                $('#input_if').removeAttr('disabled');
                $('#input_if').val({{ auth()->user()->ide_fiscal }});
                $('#input_cnss').removeAttr('disabled');
                $('#input_cnss').val({{ auth()->user()->num_cnss }});
            }
            });
        })

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').empty();
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(800);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
    </script>

    @if (!($errors->isEmpty()))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif

@endsection
