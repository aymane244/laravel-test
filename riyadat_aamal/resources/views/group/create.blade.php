
@extends('layouts.ChatGroup')
@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<style>
    body{
        background-color: #e1e9f578;
    }
</style>
@endsection
@section('content')
<div class="mt-5" style="text-align: center;margin-bottom: 90px">
    <h1 style="font-weight: 900">Create groupes</h1>
    <div class="h-divider-title">
        <div class="shadow"></div>
    </div>
</div>
<div class="container">
     <div class="row justify-content-center">
         <div class="col-md-6 mt-5 mb-5">
               <div class="card">


                <div class="card-body">
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                        </div>
                @endif
                <div style="text-align: center">
                    <img src="{{ asset('img/g4.jpg') }}" width="100%" style="" class="">
                </div>
                    <form method="POST" action="/group/create">
                    @csrf

                        <div class="form-group row" style="text-align: center">
                              <label for="name" class="col-xl-4 col-form-label text-md-right pt-sm-4">Group name :</label>

                            <div class="col-xl-6 mt-3">
                                <input id="name" type="text" class="form-control " name="name" value="" required autocomplete="name" autofocus>

                                @error('name')
                                   <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                   </span>
                                @enderror
                            </div>
                            </div> <br>

                        <div class="form-group row mb-2">
                        <div class="col-xl-12 text-center">
                          <button type="submit" class="btn btn-primary">
                                    Create a group
                          </button>
                       </div>
                     </div>
                  </form>

           </div>
        </div>
     </div>
   </div>
</div>
@endsection
