@extends('layouts.app')
@section('title') Calendar @endsection
@section('css')
    @livewireStyles
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection

@section('content')

<div class="mt-5" style="text-align: center;margin-bottom: 90px">
    <h1 style="font-weight: 900">Calender</h1>
    <div class="h-divider-title">
        <div class="shadow"></div>
    </div>
</div>

<livewire:calendar />

@endsection

@section('script')
    @livewireScripts
    @stack('scripts')
@endsection


