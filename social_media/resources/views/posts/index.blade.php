@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4 col-sm-12 px-5" style="padding-top:50px;">
                <img src="/storage/{{ $post->image }}" class="w-100">
                <div class="d-flex pb-3 align-items-center pt-5 ">
                    <div class="offset-2">
                        <img src="{{$post->user->profile->profileImage()}}" alt="" class="w-100 rounded-circle" style="max-width:50px;">
                    </div>
                    <div class="d-flex align-items-center">
                        <h5 class="px-3 pt-2" style="font-weight:bold;">
                            <a href="/profile/{{$post->user->id}}" style="text-decoration: none; color:black;">{{$post->user->username}}</a>
                        </h5>
                        <link-button user-id="{{$post->user->id}}" follows="{{$follows}}" ></link-button>
                    </div>
                </div>
                <div class="offset-2">
                    <p>
                        <span style="font-weight:bold;">
                            <a href="/profile/{{$post->user->id}}" style="text-decoration: none; color:black;">{{$post->user->username}}</a>
                        </span> {{$post->caption}}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection