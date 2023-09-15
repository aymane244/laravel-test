@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
        @foreach($users as $user)
            @if($id != $user->id)
                <div class="col-md-4 col-sm-12 px-5" style="padding-top:50px;">
                    <div class="d-flex pb-3 align-items-center pt-5 ">
                        <img src="{{$user->profile->profileImage()}}" class="rounded-circle" style="height:120px">
                        <p class="px-3">{{$user->name}}<br>
                        <a href="/profile/{{$user->id}}" class="pb-3" style="text-decoration:none;">View profile</a></p>
                    </div>
                </div>
            @endif    
        @endforeach
        </div>
    </div>
@endsection