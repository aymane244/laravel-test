@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit your profile</h2>
    <form action="/profile/{{Auth::user()->id}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group row">
            <div class="row mb-3">
                <label for="title" class="col-md-4 col-form-label">{{ __('Title') }}</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror w-75" name="title" value="{{ old('title') ?? Auth::user()->profile->title}}"  autocomplete="title" autofocus>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="row mb-3">
                <label for="description" class="col-md-4 col-form-label">{{ __('Description') }}</label>
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror w-75" name="description" value="{{ old('description') ?? Auth::user()->profile->description}}"  autocomplete="description" autofocus>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="row mb-3">
                <label for="url" class="col-md-4 col-form-label">{{ __('URL') }}</label>
                    <input id="url" type="link" class="form-control @error('url') is-invalid @enderror w-75" name="url" value="{{ old('url') ?? Auth::user()->profile->url}}"  autocomplete="url" autofocus>
                    @error('url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Image') }}</label>
            <input type="file" class="form-control-file" id="image" name="image"> 
            @error('image')
                
                    <strong class="text-danger">{{ $message }}</strong>
                
            @enderror
        </div>
        <div class="pt-4">
            <button class="btn btn-primary">Edit profile</button>
        </div>
    </form>
</div>
@endsection