@extends('layouts.app')
@section('title') Home @endsection

@section('content')

    @if (session('status'))
        <div class="form-alerts toasts">
            <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">
                <div class="d-flex align-items-center">
                    <i class="fa fa-cube" style="color: white;font-size: 30px"></i>
                    <p><b class="d-flex">{{ session('status') }}.</b></p>
                </div>
            </div>
        </div>
    @endif

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        You are logged in
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (session('status'))
        <script type="text/javascript">
            setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );
        </script>
    @endif
@endsection
