@extends('layouts.app')
@section('title') Recommandation @endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">
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

{{-- Modal confirmation et update --}}
    <div class="window" style="display: none"></div>
    {{-- Modal --}}
    <div class="modal" id="modal_recommandation">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="exampleModalLabel">Créer recommandation</h5>
              <button type="button" class="close" onclick="$('.window').css('display','none');$('.modal').css('display','none');">
                &times;
              </button>
            </div>
            <form method="POST" action="{{ route('recommandation.store') }}">
                @csrf

              <div class="modal-body">
                <div class="form-group">
                  <label for="title">Titre de recommandation</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="saisie titre" required>
                </div>
            </div>
              <div class="modal-footer border-top-0 d-flex justify-content-center">
                <input type="hidden" id="id_entreprise_recom" name="id_entreprise_recom" value="{{ $entreprise_recom->id }}">
                <button type="submit" class="btn btn-primary">Créer</button>
              </div>
            </form>
          </div>
        </div>
    </div>

{{-- Contenu --}}
    <div class="mt-5" style="text-align: center;margin-bottom: 45px">
        <h1 style="font-weight: 900">Recommandation</h1>
        <div class="h-divider-title">
            <div class="shadow"></div>
        </div>
    </div>

    <div class="container-fluid wow fadeIn" data-wow-duration="1.5s">
        <div class="main-body">
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">BrandName</a></li>
                  <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $entreprise_recom->name }}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Recommandation</li>
                </ol>
            </nav>


                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="d-flex align-items-center mb-5">Rating d'entreprise</h5>

                                <div class="d-flex flex-column align-items-center text-center">

                                    @if ($entreprise_recom->logo==NULL)
                                        @php
                                            $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                            $color = $colors[array_rand($colors)];
                                        @endphp
                                        <div class="logo_virtual_profile" style="background-color: @php echo $color; @endphp">
                                            <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 43px">@php echo substr($entreprise_recom->name, 0, 1); @endphp </h5>
                                        </div>
                                    @else
                                        <img src="{{ asset('img/logos/'.$entreprise_recom->logo.'') }}" alt="{{ $entreprise_recom->name }}" class="rounded-circle" style="width:225px;height:225px">
                                    @endif

                                    <div class="mt-3">
                                        <h4>{{ $entreprise_recom->name }}</h4>
                                        <p class="text-secondary mb-1">{{ $entreprise_recom->type_entreprise }}</p>
                                        <p class="text-muted font-size-sm">{{ $entreprise_recom->adress }}</p>
                                        <a class="btn btn-primary" href="#" onclick="add_recommandation()">Recommander</a>
                                    </div>

                                    <div class="rating-row px-1 py-2 mt-3 mx-auto">
                                        <ul class="rating_entreprise">
                                          <li class=""><i class="@if($entreprise_recom->rating >= 1 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                          <li class=""><i class="@if($entreprise_recom->rating >= 2 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                          <li class=""><i class="@if($entreprise_recom->rating >= 3 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                          <li class=""><i class="@if($entreprise_recom->rating >= 4 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                          <li class=""><i class="@if($entreprise_recom->rating >= 5 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                        </ul>
                                    </div>
                                    <div class="card-body" style="width: 100%">
                                        <p>Projects: ({{$count_projects}})</p>
                                        <div class="progress mb-3" style="height: 7px;background-color: #b1bcc7;">
                                            <div class="progress-bar bg-primary" role="progressbar"  style="@if($count_projects==0) width: 80% @endif @if($count_projects==0) width: 0% @endif @if($count_projects==1) width: 20% @endif @if($count_projects==2) width: 40% @endif @if($count_projects==3) width: 60% @endif @if($count_projects==4) width: 80% @endif @if($count_projects==5) width: 100% @endif" aria-valuenow="{{$count_projects}}" aria-valuemin="0" aria-valuemax="5"></div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h5 class="d-flex align-items-center mb-4">Social Media</h5>

                                <ul class="list-group list-group-flush">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item mb-2 pt-3 pb-3">
                                            <h6 class="mb-1"><i class="fa fa-globe icon_sociel_media"></i>Website</h6>
                                            <a class="text-secondary" target="_blank" href="{{ $entreprise_recom->website }}" >{{ $entreprise_recom->website }}</a>
                                          </li>
                                          <li class="list-group-item mb-2 pt-3 pb-3">
                                            <h6 class="mb-1"><i class="fa fa-facebook icon_sociel_media"></i>Facebook</h6>
                                            <a class="text-secondary" target="_blank" href="{{ $entreprise_recom->facebook }}" >{{ $entreprise_recom->facebook }}</a>
                                          </li>
                                          <li class="list-group-item mb-2 pt-3 pb-3">
                                            <h6 class="mb-1"><i class="fa fa-instagram icon_sociel_media"></i>Instagram</h6>
                                            <a class="text-secondary" target="_blank" href="{{ $entreprise_recom->instagram }}" >{{ $entreprise_recom->instagram }}</a>
                                          </li>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="d-flex align-items-center mb-5">Comments</h5>
                                <div class="comment-section">
                                    <div class="" style="width: 100%">
                                      <div class="review">
                                        <div class="comment-section">

                                            @foreach ($recommandations as $recommandation)
                                                <div class="media media-review">
                                                    <div class="media-user">
                                                        @if ($recommandation->user->logo==NULL)
                                                            @php
                                                            $colors= array('green','red','chocolate','coral','tomato','sienna','darkorange','forestgreen','orangered','brown','dimgray','palevioletred','peru');
                                                            $color = $colors[array_rand($colors)];
                                                            @endphp
                                                            <div class="logo_virtual" style="background-color: @php echo $color; @endphp;width:100%;height:100%">
                                                                <h5 class="text-center" style="color: white;padding-top: 24px">@php echo substr($recommandation->user->name, 0, 1); @endphp </h5>
                                                            </div>
                                                        @else
                                                            <img src="{{ asset('img/logos/'.$recommandation->user->logo.'') }}" alt="{{ $recommandation->user->name }}">
                                                        @endif
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="M-flex">
                                                            <h2 class="title"><span> {{ $recommandation->user->name }} </span>{{ $recommandation->date_recom }}</h2>
                                                            <div class="rating-row">
                                                                <ul>
                                                                    <li class=""><i class="@if($recommandation->rating >= 1 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                    <li class=""><i class="@if($recommandation->rating >= 2 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                    <li class=""><i class="@if($recommandation->rating >= 3 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                    <li class=""><i class="@if($recommandation->rating >= 4 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                    <li class=""><i class="@if($recommandation->rating >= 5 ) fa fa-star @else fa fa-star-o @endif"></i></li>
                                                                </ul>

                                                            </div>
                                                        </div>
                                                        <div class="description">{{ $recommandation->comment }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div>{{ $recommandations->links() }}</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection


@section('script')
   @if (!($errors->isEmpty()) || session('message'))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif

    <script>
        function add_recommandation(){
            $('.window').css('display','block');
            $('.modal').css('display','block');
        }

        var modal = document.getElementById('modal_recommandation');
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                $('.window').css('display','none');
            }
        }
    </script>
@endsection
