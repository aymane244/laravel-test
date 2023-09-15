@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add new post</h2>
    <form action="/p" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="row mb-3">
                <label for="caption" class="col-md-4 col-form-label">{{ __('Post Caption') }}</label>
                    <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror w-75" name="caption" value="{{ old('caption') }}"  autocomplete="caption" autofocus>
                    @error('caption')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
        </div>
        <div class="row">
            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Post Image') }}</label>
            <input type="file" class="form-control-file" id="image" name="image"> 
            @error('image')
                
                    <strong class="text-danger">{{ $message }}</strong>
                
            @enderror
        </div>
        <div class="pt-4">
            <button class="btn btn-primary">Add new post</button>
        </div>
    </form>
</div>
@endsection