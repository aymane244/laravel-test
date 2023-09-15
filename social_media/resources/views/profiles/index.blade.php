@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3" style="padding-top:50px; padding-left:150px;">
            <img src="{{$user->profile->profileImage()}}" class="rounded-circle" style="height:120px">
        </div>
        <div class="col-7" style="padding-top:50px; padding-left:100px;">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <h3 class="px-3">{{ $user->username }}</h3>
                    @if($id != $user->id)
                    <follow-button user-id="{{$user->id}}" follows="{{$follows}}"></follow-button>
                    @endif
                </div>
                @can('update', $user->profile)
                    <a href="/p/create/" class="btn btn-success">Add post</a>
                @endcan
            </div>
            @can('update', $user->profile)
            <div class="px-3">
                <a href="/profile/{{$user->id}}/edit" class="btn btn-danger">Edit Profile</a>
            </div>
            @endcan
            <div class="d-flex pt-3">
                <div class="px-3"><strong> {{$user->posts->count()}}</strong> posts</div>
                <div class="px-3"><strong>{{$user->profile->followers->count()}}</strong> followers</div>
                <div class="px-3"><strong>{{$user->following->count()}}</strong> following</div>
            </div>
            <div class="px-3">
                <p>
                    <span class="font-size:20px"><strong>{{$user->profile->title}}</strong></span><br>
                    {{$user->profile->description}}<br>
                    <a href="" class="text-dark">{{$user->profile->url ?? 'N/A'}}</a>
                </p>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-md-4 col-sm-12" style="padding-top:50px; padding-left:150px;">
                <a href="/p/{{$post->id}}">
                    <img src="/storage/{{ $post->image }}" class="w-100" alt="database image">
                </a>
                <!--Auth::user()-->
            </div>
        @endforeach
    </div>
</div>
@endsection