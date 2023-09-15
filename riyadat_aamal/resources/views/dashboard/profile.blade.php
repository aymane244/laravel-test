@extends('dashboard.layout')
@section('title') Profile admin @endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Dashboard Template </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile Admin</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 wow fadeIn" data-wow-duration="1.5s" style="margin: 0 auto">
                    <div class="card">
                        <form id="form" action="{{ route('dashboard.update',0) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                            <h5 class="card-header">Admin</h5>
                            <div class="card-body">
                                <div class="card-body">
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
                                                    <h5 class="text-center text-white" style="font-size: xxx-large;padding-top: 90px">@php echo substr(auth()->user()->name, 0, 1); @endphp </h5>
                                                </div>
                                            @else
                                                <div id="imagePreview" style="background-image: url('{{ asset('img/logos/'.Auth::user()->logo.'') }}');"></div>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <label for="inputEmail2" class="col-12 col-form-label">Email</label>
                                        <div class="col-12">
                                            <input id="inputEmail2" type="email" name="email" required="" placeholder="Email" class="form-control" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail2" class="col-12 col-form-label">Name</label>
                                        <div class="col-12">
                                            <input id="inputEmail2" type="text" name="name" required="" placeholder="Name" class="form-control" value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword2" class="col-12 col-form-label">current Password</label>
                                        <div class="col-12">
                                            <input id="inputPassword2" required type="password" name="current_password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword2" class="col-12 col-form-label">New Password</label>
                                        <div class="col-12">
                                            <input id="inputPassword2" type="password" name="new_password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword2" class="col-12 col-form-label">Confirm new Password</label>
                                        <div class="col-12">
                                            <input id="inputPassword2" type="password" name="confirm_password" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row pt-2 pt-sm-5 mt-1">
                                        <div class="col-sm-6 pl-0">
                                            <p class="text-right">
                                                <button type="submit" class="btn btn-space btn-primary">Submit</button>
                                            </p>
                                        </div>
                                    </div>
                            </div>
                        </form>
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
@endsection
