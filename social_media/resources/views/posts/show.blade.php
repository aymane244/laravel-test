@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <img src="/storage/{{ $post->image }}" class="w-100" alt="database image">
        </div>
        <div class="col-md-4 px-4">
            <div class="d-flex pb-3 align-items-center pt-5 ">
                <div>
                    <img src="{{$post->user->profile->profileImage()}}" alt="" class="w-100 rounded-circle" style="max-width:50px">
                </div>
                <div class="d-flex">
                    <h5 class="px-3" style="font-weight:bold;">
                        <a href="/profile/{{$post->user->id}}" style="text-decoration: none; color:black;">{{$post->user->username}}</a>
                    </h5>
                    <a href="#" style="text-decoration: none; font-weight:bold;" class="px-3">Follow</a>
                </div>
            </div>
            <p>
                <span style="font-weight:bold;">
                    <a href="/profile/{{$post->user->id}}" style="text-decoration: none; color:black;">{{$post->user->username}}</a>
                </span> {{$post->caption}}
            </p>
        </div>
    </div>
</div>
@endsection