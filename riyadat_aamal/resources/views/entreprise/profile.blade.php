@extends('layouts.app')
@section('title') Profile @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">
@endsection


@section('content')

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
    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Profile</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="main-body">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">BrandName</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0)">{{{ Auth::user()->name }}}</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
          </nav>
          <!-- /Breadcrumb -->

          <div class="row gutters-sm">
            <div class="col-lg-4 mb-3">
              <div class="card">
                <div class="card-body">
                <h5 class="d-flex align-items-center mb-3">Logo</h5>
                  <div class="d-flex flex-column align-items-center text-center">

                    @if (auth()->user()->logo==NULL)
                        @php
                            $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                            $color = $colors[array_rand($colors)];
                        @endphp
                        <div class="logo_virtual_profile" style="background-color: @php echo $color; @endphp">
                            <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 43px">@php echo substr(auth()->user()->name, 0, 1); @endphp </h5>
                        </div>
                    @else
                        <img src="{{ asset('img/logos/'.Auth::user()->logo.'') }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width:225px;height:225px">
                    @endif

                    <div class="mt-3">
                      <h4>{{ auth()->user()->name }}</h4>
                      <p class="text-secondary mb-1">{{ auth()->user()->type_entreprise }}</p>
                      <p class="text-muted font-size-sm">{{ auth()->user()->adress }}</p>
                    </div>

                    <div class="rating-row px-1 py-2 mt-3 mx-auto">
                        <ul class="rating_entreprise">
                          <li class=""><i class="@if(Auth::user()->rating >= 1 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                          <li class=""><i class="@if(Auth::user()->rating >= 2 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                          <li class=""><i class="@if(Auth::user()->rating >= 3 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                          <li class=""><i class="@if(Auth::user()->rating >= 4 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                          <li class=""><i class="@if(Auth::user()->rating >= 5 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                        </ul>
                    </div>
                    <div class="card-body" style="width: 100%">
                        <p>Projects: ({{$count_projects}})</p>
                        <div class="progress mb-3" style="height: 7px;background-color: #b1bcc7;">
                          <div class="progress-bar bg-primary" role="progressbar"  style="@if($count_projects==0) width: 80% @endif @if($count_projects==0) width: 0% @endif @if($count_projects==1) width: 20% @endif @if($count_projects==2) width: 40% @endif @if($count_projects==3) width: 60% @endif @if($count_projects==4) width: 80% @endif @if($count_projects==5) width: 100% @endif" aria-valuenow="{{$count_projects}}" aria-valuemin="0" aria-valuemax="5"></div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="card mt-5">
              <h5 class="d-flex align-items-center mb-3 mt-3" style="margin-left: 15px;">Social media</h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item mb-2 pt-3 pb-3">
                    <h6 class="mb-1"><i class="fa fa-globe icon_sociel_media"></i>Website</h6>
                    <a class="text-secondary" target="_blank" href="{{ auth()->user()->website }}" >{{ auth()->user()->website }}</a>
                  </li>
                  <li class="list-group-item mb-2 pt-3 pb-3">
                    <h6 class="mb-1"><i class="fa fa-facebook icon_sociel_media"></i>Facebook</h6>
                    <a class="text-secondary" target="_blank" href="{{ auth()->user()->facebook }}" >{{ auth()->user()->facebook }}</a>
                  </li>
                  <li class="list-group-item mb-2 pt-3 pb-3">
                    <h6 class="mb-1"><i class="fa fa-instagram icon_sociel_media"></i>Instagram</h6>
                    <a class="text-secondary" target="_blank" href="{{ auth()->user()->instagram }}" >{{ auth()->user()->instagram }}</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-body">
                <h5 class="d-flex align-items-center mb-5">Entreprise informations</h5>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->name }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->email }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->tele }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">Le Registre de Commerce (RC)</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->num_rc }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">L’Identifiant Fiscal et la patente (IF)</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->ide_fiscal }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">Numéro d’affiliation à la CNSS</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->num_cnss }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">Identifiant Commun de l’Entreprise (ICE)</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->num_ice }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-4 mt-4">
                    <div class="col-sm-5">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        {{ auth()->user()->adress }}
                    </div>
                  </div>
                  <hr>
                  <div class="row mb-2" style="text-align: right">
                    <div class="col-sm-12 mt-3">
                      <a class="btn btn-primary" style="width: 150px" href="{{ route('entreprises.edit',' ') }}">Edit</a>
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
    @if (session('message'))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif
@endsection
